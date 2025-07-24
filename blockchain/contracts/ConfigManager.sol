// SPDX-License-Identifier: MIT
pragma solidity ^0.8.28;

import "./AccessManager.sol";

contract ConfigManager {

    // ======== VARIABLES ========
    AccessManager public access;

    // ======== CONSTRUCTOR ========

    constructor(address accessAddress) {
        access = AccessManager(accessAddress);
    }

    // ======== MODIFIERS ========
    modifier onlyOwner() {
        require(access.hasRole(access.DEFAULT_ADMIN_ROLE(), msg.sender), "Not admin");
        _;
    }
    
    /**
     * @dev Transfers ownership of the contract
     */
    function transferOwnership(address _newAdmin) external onlyOwner{
        access.grantRole(access.DEFAULT_ADMIN_ROLE(), _newAdmin);
        access.revokeRole(access.DEFAULT_ADMIN_ROLE(), msg.sender);
    }
}