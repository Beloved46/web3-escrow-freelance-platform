// SPDX-License-Identifier: MIT
pragma solidity ^0.8.17;

import {AccessControl} from "@openzeppelin/contracts/access/AccessControl.sol";

contract AccessManager is AccessControl {
    // ======== ROLES CONSTANT VARIABLES ========

    bytes32 public constant ARBITRATOR_ROLE = keccak256("ARBITRATOR_ROLE");

    constructor(address admin) {
        _grantRole(DEFAULT_ADMIN_ROLE, admin); //platform owner
        _grantRole(ARBITRATOR_ROLE, admin);    // Optional: owner is also an arbitrator
    }

    function grantArbitratorRole(address account) external onlyRole(DEFAULT_ADMIN_ROLE) {
        _grantRole(ARBITRATOR_ROLE, account);
    }

    function revokeArbitratorRole(address account) external onlyRole(DEFAULT_ADMIN_ROLE) {
        _revokeRole(ARBITRATOR_ROLE, account);
    }

    function isArbitrator(address account) external view returns (bool) {
        return hasRole(ARBITRATOR_ROLE, account);
    }
}