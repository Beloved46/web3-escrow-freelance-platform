const { buildModule } = require("@nomicfoundation/hardhat-ignition/modules");
const EscrowModule = require("./EscrowModule");

module.exports = buildModule("SetupModule", (m) => {
  // Import the deployed contracts
  const { accessManager, escrow } = m.useModule(EscrowModule);
  
  // Optional: Add additional arbitrators
  // const arbitratorAddress = m.getParameter("arbitratorAddress");
  // m.call(accessManager, "grantArbitratorRole", [arbitratorAddress]);
  
  // Optional: Update platform fee (default is 5%)
  // const platformFee = m.getParameter("platformFee", 5);
  // m.call(escrow, "updatePlatformFee", [platformFee]);
  
  // Optional: Set custom fee collector
  // const feeCollector = m.getParameter("feeCollector");
  // m.call(escrow, "updateFeeCollector", [feeCollector]);
  
  return { accessManager, escrow };
});