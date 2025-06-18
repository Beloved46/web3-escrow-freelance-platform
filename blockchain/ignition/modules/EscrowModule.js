const { buildModule } = require("@nomicfoundation/hardhat-ignition/modules");

module.exports = buildModule("EscrowModule", (m) => {
  // Get deployer account - this will be the initial admin
  const deployer = m.getAccount(0);
  
  // Platform fee parameter (1.2% = 120 basis points, but contract uses percentage)
  const platformFeePercent = m.getParameter("platformFee", 1); // Will be 1% for now, update later
  
  // Deploy AccessManager first
  const accessManager = m.contract("AccessManager", [deployer]);
  
  // Deploy ConfigManager with AccessManager address
  const configManager = m.contract("ConfigManager", [accessManager]);
  
  // Deploy Helper contract (utility functions)
  const helper = m.contract("Helper", []);
  
  // Deploy main Escrow contract with AccessManager address
  const escrow = m.contract("Escrow", [accessManager]);
  
  // Return all deployed contracts for easy access
  return {
    accessManager,
    configManager,
    helper,
    escrow,
    deployer
  };
});