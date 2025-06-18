// SPDX-License-Identifier: MIT
pragma solidity ^0.8.17;

import "./AccessManager.sol";
import "./ConfigManager.sol";
import {ReentrancyGuard} from "@openzeppelin/contracts/utils/ReentrancyGuard.sol";
import "@openzeppelin/contracts/utils/Pausable.sol";

/**
 * @title Bondr Escrow Contract
 * @dev Manages escrow payments between creators and clients with milestone functionality
 */
contract Escrow is ReentrancyGuard, Pausable{
    // ======== ENUMS & STRUCTS ========
    
    enum AgreementStatus { 
        Created,    // Agreement created but not yet funded
        Funded,     // Client has funded the escrow
        InProgress, // Work is in progress
        Disputed,   // Agreement is under dispute
        Completed,  // Work completed and funds released
        Cancelled   // Agreement cancelled and funds returned to client
    }
    
    enum MilestoneStatus { 
        Pending,   // Milestone created but not yet approved
        Approved,  // Client approved the milestone work
        Rejected   // Client rejected the milestone work
    }
    
    struct Milestone {
        string description;
        uint256 amount;
        MilestoneStatus status;
        uint256 completionTime; // When the milestone was marked as completed
        // ======== TODO FOR TIMOUT MILESTONES ========
        // bool isSubmitted;
        // bool isApproved;
        // uint256 submittedAt;
        // bool disputed;
    }
    
    struct Agreement {
        address client;
        address creator;
        string description;
        uint256 totalAmount;
        uint256 platformFee; // Fee charged by Bondr
        uint256 createdAt;
        uint256 deadline; // Optional deadline for work completion
        AgreementStatus status;
        uint256 fundedAmount; // Total amount funded by client
        uint256 releasedAmount; // Total amount released to creator
        uint256 disputeId; // ID of dispute if status is Disputed
        Milestone[] milestones;
    }

    // ======== STATE VARIABLES ========

    ConfigManager public configManager;
    AccessManager public accessManager;
    uint256 private nextAgreementId = 1;
    uint256 private nextDisputeId = 1;
    uint256 public platformFeePercent = 2; // 2% platform fee
    // address public owner;
    address public feeCollector;
    
    // Mappings
    mapping(uint256 => Agreement) public agreements;
    mapping(uint256 => address) public disputeArbitrators; // Maps dispute IDs to assigned arbitrators
    
    // ======== EVENTS ========
    
    event AgreementCreated(uint256 indexed agreementId, address indexed client, address indexed creator, uint256 totalAmount);
    event AgreementFunded(uint256 indexed agreementId, uint256 amount);
    event MilestoneAdded(uint256 indexed agreementId, uint256 milestoneIndex, string description, uint256 amount);
    event MilestoneCompleted(uint256 indexed agreementId, uint256 milestoneIndex);
    event MilestoneApproved(uint256 indexed agreementId, uint256 milestoneIndex);
    event MilestoneRejected(uint256 indexed agreementId, uint256 milestoneIndex, string reason);
    event FundsReleased(uint256 indexed agreementId, uint256 amount, address recipient);
    event AgreementDisputed(uint256 indexed agreementId, uint256 disputeId, string reason);
    event DisputeResolved(uint256 indexed disputeId, uint256 agreementId, address winner);
    event AgreementCancelled(uint256 indexed agreementId);
    
    // ======== MODIFIERS ========
    
    modifier onlyOwner() {
        // require(msg.sender == owner, "Only contract owner can call this function");
        require(accessManager.hasRole(accessManager.DEFAULT_ADMIN_ROLE(), msg.sender), "Not admin");
        _;
    }
    
    modifier onlyClient(uint256 _agreementId) {
        require(msg.sender == agreements[_agreementId].client, "Only client can call this function");
        _;
    }
    
    modifier onlyCreator(uint256 _agreementId) {
        require(msg.sender == agreements[_agreementId].creator, "Only creator can call this function");
        _;
    }
    
    modifier onlyClientOrCreator(uint256 _agreementId) {
        require(
            msg.sender == agreements[_agreementId].client || 
            msg.sender == agreements[_agreementId].creator, 
            "Only client or creator can call this function"
        );
        _;
    }
    
    modifier onlyArbitrator(uint256 _disputeId) {
        require(accessManager.isArbitrator(msg.sender), "Not an arbitrator");
        // require(msg.sender == disputeArbitrators[_disputeId], "Only assigned arbitrator can call this function");
        _;
    }
    
    // ======== CONSTRUCTOR ========
    
    constructor(address _accessManager) {
        accessManager = AccessManager(_accessManager);
        configManager = ConfigManager(_accessManager);
        // owner = msg.sender;
        feeCollector = msg.sender; // Initially, the owner collects fees
    }
    
    // ======== EXTERNAL/PUBLIC FUNCTIONS ========
    
    /**
     * @dev Creates a new agreement between client and creator
     * @param _creator Address of the creator/freelancer
     * @param _description Description of the work to be done
     * @param _deadline Optional deadline for work completion (0 for no deadline)
     * @return agreementId The ID of the newly created agreement
     */
    function createAgreement(
        address _creator, 
        string memory _description, 
        uint256 _deadline
    ) external returns (uint256) {
        require(_creator != address(0), "Invalid creator address");
        require(_creator != msg.sender, "Client and creator cannot be the same");
        
        uint256 agreementId = nextAgreementId++;
        
        Agreement storage newAgreement = agreements[agreementId];
        newAgreement.client = msg.sender;
        newAgreement.creator = _creator;
        newAgreement.description = _description;
        newAgreement.createdAt = block.timestamp;
        newAgreement.deadline = _deadline;
        newAgreement.status = AgreementStatus.Created;
        
        emit AgreementCreated(agreementId, msg.sender, _creator, 0);
        
        return agreementId;
    }
    
    /**
     * @dev Adds a milestone to an agreement
     * @param _agreementId ID of the agreement
     * @param _description Description of the milestone
     * @param _amount Amount allocated to this milestone
     */
    function addMilestone(
        uint256 _agreementId, 
        string memory _description, 
        uint256 _amount
    ) external onlyClientOrCreator(_agreementId) {
        Agreement storage agreement = agreements[_agreementId];
        require(
            agreement.status == AgreementStatus.Created || 
            agreement.status == AgreementStatus.Funded, 
            "Cannot add milestone to agreement in current state"
        );
        
        Milestone memory newMilestone = Milestone({
            description: _description,
            amount: _amount,
            status: MilestoneStatus.Pending,
            completionTime: 0
        });
        
        agreement.milestones.push(newMilestone);
        agreement.totalAmount += _amount;
        
        emit MilestoneAdded(
            _agreementId, 
            agreement.milestones.length - 1, 
            _description, 
            _amount
        );
    }
    
    /**
     * @dev Client funds the agreement or adds additional funding
     */
    function fundAgreement(uint256 _agreementId) external payable onlyClient(_agreementId) nonReentrant() whenNotPaused(){
        Agreement storage agreement = agreements[_agreementId];
        require(
            agreement.status == AgreementStatus.Created || 
            agreement.status == AgreementStatus.Funded, 
            "Cannot fund agreement in current state"
        );
        require(msg.value > 0, "Funding amount must be greater than 0");
        
        // Calculate platform fee
        uint256 fee = (msg.value * platformFeePercent) / 100;
        uint256 netAmount = msg.value - fee;
        
        agreement.fundedAmount += netAmount;
        agreement.platformFee += fee;
        agreement.status = AgreementStatus.Funded;
        
        // Transfer fee to fee collector
        (bool feeTransferSuccess, ) = feeCollector.call{value: fee}("");
        require(feeTransferSuccess, "Fee transfer failed");
        
        emit AgreementFunded(_agreementId, msg.value);
    }
    
    /**
     * @dev Creator marks a milestone as completed
     */
    function completeMilestone(uint256 _agreementId, uint256 _milestoneIndex) external onlyCreator(_agreementId) whenNotPaused() {
        Agreement storage agreement = agreements[_agreementId];
        require(agreement.status == AgreementStatus.Funded, "Agreement not in funded state");
        require(_milestoneIndex < agreement.milestones.length, "Invalid milestone index");
        
        Milestone storage milestone = agreement.milestones[_milestoneIndex];
        require(milestone.status == MilestoneStatus.Pending, "Milestone not in pending state");
        
        milestone.completionTime = block.timestamp;
        
        emit MilestoneCompleted(_agreementId, _milestoneIndex);
    }
    
    /**
     * @dev Client approves a milestone and releases funds
     */
    function approveMilestone(uint256 _agreementId, uint256 _milestoneIndex) external onlyClient(_agreementId) nonReentrant() whenNotPaused(){
        Agreement storage agreement = agreements[_agreementId];
        require(agreement.status == AgreementStatus.Funded, "Agreement not in funded state");
        require(_milestoneIndex < agreement.milestones.length, "Invalid milestone index");
        
        Milestone storage milestone = agreement.milestones[_milestoneIndex];
        require(milestone.status == MilestoneStatus.Pending, "Milestone not in pending state");
        require(milestone.completionTime > 0, "Milestone not marked as completed");
        require(agreement.fundedAmount >= milestone.amount, "Insufficient funds in escrow");
        
        milestone.status = MilestoneStatus.Approved;
        
        // Update agreement amounts
        agreement.fundedAmount -= milestone.amount;
        agreement.releasedAmount += milestone.amount;
        
        // Transfer funds to creator
        (bool success, ) = agreement.creator.call{value: milestone.amount}("");
        require(success, "Fund transfer failed");
        
        emit MilestoneApproved(_agreementId, _milestoneIndex);
        emit FundsReleased(_agreementId, milestone.amount, agreement.creator);
        
        // Check if all milestones are approved - if so, mark agreement as completed
        bool allMilestonesApproved = true;
        for (uint i = 0; i < agreement.milestones.length; i++) {
            if (agreement.milestones[i].status != MilestoneStatus.Approved) {
                allMilestonesApproved = false;
                break;
            }
        }
        
        if (allMilestonesApproved && agreement.fundedAmount == 0) {
            agreement.status = AgreementStatus.Completed;
        }
    }
    
    /**
     * @dev Client rejects a milestone
     */
    function rejectMilestone(
        uint256 _agreementId, 
        uint256 _milestoneIndex, 
        string memory _reason
    ) external onlyClient(_agreementId) whenNotPaused(){
        Agreement storage agreement = agreements[_agreementId];
        require(agreement.status == AgreementStatus.Funded, "Agreement not in funded state");
        require(_milestoneIndex < agreement.milestones.length, "Invalid milestone index");
        
        Milestone storage milestone = agreement.milestones[_milestoneIndex];
        require(milestone.status == MilestoneStatus.Pending, "Milestone not in pending state");
        require(milestone.completionTime > 0, "Milestone not marked as completed");
        
        milestone.status = MilestoneStatus.Rejected;
        
        emit MilestoneRejected(_agreementId, _milestoneIndex, _reason);
    }
    
    /**
     * @dev Initiates a dispute for an agreement
     */
    function initiateDispute(uint256 _agreementId, string memory _reason) external onlyClientOrCreator(_agreementId) {
        Agreement storage agreement = agreements[_agreementId];
        require(
            agreement.status == AgreementStatus.Funded || 
            agreement.status == AgreementStatus.InProgress, 
            "Cannot dispute agreement in current state"
        );
        
        agreement.status = AgreementStatus.Disputed;
        agreement.disputeId = nextDisputeId++;
        
        emit AgreementDisputed(_agreementId, agreement.disputeId, _reason);
    }
    
    /**
     * @dev Owner assigns an arbitrator to a dispute
     */
    function assignArbitrator(uint256 _disputeId, address _arbitrator) external onlyOwner{
        require(_arbitrator != address(0), "Invalid arbitrator address");
        disputeArbitrators[_disputeId] = _arbitrator;
    }
    
    /**
     * @dev Arbitrator resolves a dispute
     */
    function resolveDispute(
        uint256 _disputeId, 
        uint256 _agreementId, 
        address _winner, 
        uint256[] memory _refundAmounts
    ) external onlyArbitrator(_disputeId) {
        Agreement storage agreement = agreements[_agreementId];
        require(agreement.status == AgreementStatus.Disputed, "Agreement not in disputed state");
        require(agreement.disputeId == _disputeId, "Dispute ID mismatch");
        require(
            _winner == agreement.client || _winner == agreement.creator, 
            "Winner must be client or creator"
        );
        
        // Validate refund amounts
        uint256 totalRefund = 0;
        for (uint i = 0; i < _refundAmounts.length; i++) {
            totalRefund += _refundAmounts[i];
        }
        require(totalRefund <= agreement.fundedAmount, "Refund amount exceeds available funds");
        
        if (_winner == agreement.client) {
            // Refund client
            (bool success, ) = agreement.client.call{value: totalRefund}("");
            require(success, "Refund transfer failed");
            
            agreement.fundedAmount -= totalRefund;
        } else {
            // Pay creator
            (bool success, ) = agreement.creator.call{value: totalRefund}("");
            require(success, "Payment transfer failed");
            
            agreement.fundedAmount -= totalRefund;
            agreement.releasedAmount += totalRefund;
        }
        
        // If no more funds in escrow, mark as completed
        if (agreement.fundedAmount == 0) {
            agreement.status = AgreementStatus.Completed;
        } else {
            agreement.status = AgreementStatus.Funded;
        }
        
        emit DisputeResolved(_disputeId, _agreementId, _winner);
    }
    
    /**
     * @dev Cancels an agreement and refunds the client
     * Only possible if no milestones have been approved yet
     */
    function cancelAgreement(uint256 _agreementId) external onlyClientOrCreator(_agreementId) whenNotPaused(){
        Agreement storage agreement = agreements[_agreementId];
        require(
            agreement.status == AgreementStatus.Created || 
            agreement.status == AgreementStatus.Funded, 
            "Cannot cancel agreement in current state"
        );
        
        // Check if any milestones have been approved
        bool milestonesApproved = false;
        for (uint i = 0; i < agreement.milestones.length; i++) {
            if (agreement.milestones[i].status == MilestoneStatus.Approved) {
                milestonesApproved = true;
                break;
            }
        }
        
        require(!milestonesApproved, "Cannot cancel agreement with approved milestones");
        
        // Refund any remaining funds to client
        if (agreement.fundedAmount > 0) {
            (bool success, ) = agreement.client.call{value: agreement.fundedAmount}("");
            require(success, "Refund transfer failed");
        }
        
        agreement.status = AgreementStatus.Cancelled;
        
        emit AgreementCancelled(_agreementId);
    }
    
    /**
     * @dev Updates the platform fee percentage
     */
    function updatePlatformFee(uint256 _newFeePercent) external onlyOwner{
        require(_newFeePercent <= 20, "Fee percentage cannot exceed 20%");
        platformFeePercent = _newFeePercent;
        
    }
    
    /**
     * @dev Updates the fee collector address
     */
    function updateFeeCollector(address _newFeeCollector) external onlyOwner{
        require(_newFeeCollector != address(0), "Invalid fee collector address");
        feeCollector = _newFeeCollector;
    }

    // ======== VIEW FUNCTIONS ========
    
    /**
     * @dev Gets the full agreement details
     */
    function getAgreement(uint256 _agreementId) external view returns (
        address client,
        address creator,
        string memory description,
        uint256 totalAmount,
        uint256 platformFee,
        uint256 createdAt,
        uint256 deadline,
        AgreementStatus status,
        uint256 fundedAmount,
        uint256 releasedAmount,
        uint256 disputeId,
        uint256 milestonesCount
    ) {
        Agreement storage agreement = agreements[_agreementId];
        
        return (
            agreement.client,
            agreement.creator,
            agreement.description,
            agreement.totalAmount,
            agreement.platformFee,
            agreement.createdAt,
            agreement.deadline,
            agreement.status,
            agreement.fundedAmount,
            agreement.releasedAmount,
            agreement.disputeId,
            agreement.milestones.length
        );
    }
    
    /**
     * @dev Gets information about a specific milestone
     */
    function getMilestone(uint256 _agreementId, uint256 _milestoneIndex) external view returns (
        string memory description,
        uint256 amount,
        MilestoneStatus status,
        uint256 completionTime
    ) {
        Agreement storage agreement = agreements[_agreementId];
        require(_milestoneIndex < agreement.milestones.length, "Invalid milestone index");
        
        Milestone storage milestone = agreement.milestones[_milestoneIndex];
        
        return (
            milestone.description,
            milestone.amount,
            milestone.status,
            milestone.completionTime
        );
    }
    
    /**
     * @dev Gets all milestones for an agreement
     * Note: This function might hit gas limits if there are too many milestones
     */
    function getAllMilestones(uint256 _agreementId) external view returns (
        string[] memory descriptions,
        uint256[] memory amounts,
        MilestoneStatus[] memory statuses,
        uint256[] memory completionTimes
    ) {
        Agreement storage agreement = agreements[_agreementId];
        uint256 length = agreement.milestones.length;
        
        descriptions = new string[](length);
        amounts = new uint256[](length);
        statuses = new MilestoneStatus[](length);
        completionTimes = new uint256[](length);
        
        for (uint i = 0; i < length; i++) {
            Milestone storage milestone = agreement.milestones[i];
            descriptions[i] = milestone.description;
            amounts[i] = milestone.amount;
            statuses[i] = milestone.status;
            completionTimes[i] = milestone.completionTime;
        }
        
        return (descriptions, amounts, statuses, completionTimes);
    }


    // ======== PAUSE FUNCTIONS ========

    function pause() external onlyOwner(){
        _pause();
        
    }

    function unpause() external onlyOwner() {
        _unpause();
    }
}