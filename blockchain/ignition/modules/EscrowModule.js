const { buildModule } = require("@nomicfoundation/hardhat-ignition/modules");

module.exports = buildModule("EscrowModule", (m) => {
  console.log("🚀 Starting Escrow deployment...");
  
  // Get deployer account
  const deployer = m.getAccount(0);
  console.log("📍 Deployer address:", deployer);
  
  // Parameters
  const platformFeePercent = m.getParameter("platformFee", 2); // 2% default
  const feeCollector = m.getParameter("feeCollector", deployer); // Use deployer as fee collector initially
  
  // console.log(`⚙️  Platform fee: ${Number(platformFeePercent).toString()}%`);
  // console.log("💰 Fee collector:", feeCollector.toString());
  
  // Step 1: Deploy AccessManager
  console.log("1️⃣  Deploying AccessManager...");
  const accessManager = m.contract("AccessManager", [deployer], {
    id: "AccessManager"
  });
  
  // Step 2: Deploy ConfigManager
  console.log("2️⃣  Deploying ConfigManager...");
  const configManager = m.contract("ConfigManager", [accessManager], {
    id: "ConfigManager",
    after: [accessManager]
  });
  
  // Step 3: Deploy Helper contract
  console.log("3️⃣  Deploying Helper...");
  const helper = m.contract("Helper", [], {
    id: "Helper"
  });
  
  // Step 4: Deploy main Escrow contract
  console.log("4️⃣  Deploying Escrow...");
  const escrow = m.contract("Escrow", [accessManager], {
    id: "Escrow",
    after: [accessManager]
  });
  
  // Step 5: Configure the escrow contract (if needed)
  // Note: These would typically be done in a separate script after deployment
  console.log("✅ All contracts deployed successfully!");
  
  return {
    accessManager,
    configManager,
    helper,
    escrow,
    deployer,
    platformFeePercent,
    feeCollector
  };
});
