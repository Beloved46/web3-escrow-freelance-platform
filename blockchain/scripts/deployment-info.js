const fs = require('fs');
const path = require('path');

async function main() {
  const network = hre.network.name;
  const chainId = network === 'baseSepolia' ? 84532 : 8453;
  
  try {
    const deploymentPath = `./ignition/deployments/chain-${chainId}/deployed_addresses.json`;
    const deploymentResult = JSON.parse(fs.readFileSync(deploymentPath, 'utf8'));
    
    const contracts = {
      network: network,
      chainId: chainId,
      explorer: network === 'baseSepolia' ? 'https://sepolia.basescan.org' : 'https://basescan.org',
      contracts: {
        AccessManager: deploymentResult["EscrowModule#AccessManager"],
        ConfigManager: deploymentResult["EscrowModule#ConfigManager"],
        Helper: deploymentResult["EscrowModule#Helper"],
        Escrow: deploymentResult["EscrowModule#Escrow"]
      }
    };
    
    console.log("🎉 Deployment Information:");
    console.log("==========================");
    console.log(`Network: ${contracts.network}`);
    console.log(`Chain ID: ${contracts.chainId}`);
    console.log(`Explorer: ${contracts.explorer}`);
    console.log("\n📝 Contract Addresses:");
    console.log("======================");
    
    Object.entries(contracts.contracts).forEach(([name, address]) => {
      console.log(`${name}: ${address}`);
      console.log(`   View: ${contracts.explorer}/address/${address}`);
    });
    
    // Save to a JSON file for frontend use
    const frontendConfig = {
      ...contracts,
      timestamp: new Date().toISOString()
    };
    
    fs.writeFileSync(
      './deployment-config.json', 
      JSON.stringify(frontendConfig, null, 2)
    );
    
    console.log("\n💾 Configuration saved to deployment-config.json");
    
  } catch (error) {
    console.error("❌ Error reading deployment info:", error);
  }
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});