const hre = require("hardhat");

async function main() {
  const deploymentResult = require("../ignition/deployments/chain-84532/deployed_addresses.json");
  
  console.log("🔍 Verifying contracts on BaseScan...");
  
  try {
    // Verify AccessManager
    await hre.run("verify:verify", {
      address: deploymentResult["EscrowModule#AccessManager"],
      constructorArguments: [
        // Add constructor args if any
      ],
    });
    
    // Verify ConfigManager
    await hre.run("verify:verify", {
      address: deploymentResult["EscrowModule#ConfigManager"],
      constructorArguments: [
        deploymentResult["EscrowModule#AccessManager"]
      ],
    });
    
    // Verify Helper
    await hre.run("verify:verify", {
      address: deploymentResult["EscrowModule#Helper"],
      constructorArguments: [],
    });
    
    // Verify Escrow
    await hre.run("verify:verify", {
      address: deploymentResult["EscrowModule#Escrow"],
      constructorArguments: [
        deploymentResult["EscrowModule#AccessManager"]
      ],
    });
    
    console.log("✅ All contracts verified successfully!");
    
  } catch (error) {
    console.error("❌ Verification failed:", error);
  }
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});