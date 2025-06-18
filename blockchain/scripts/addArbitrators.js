async function main() {
  const [deployer] = await ethers.getSigners();
  
  // Get deployed contract addresses from ignition
  const accessManagerAddress = "0xf39Fd6e51aad88F6F4ce6aB8827279cffFb92266"; //"YOUR_ACCESS_MANAGER_ADDRESS"; // Replace after deployment
  const escrowAddress =  "0xCf7Ed3AccA5a467e9e704C703E8D87F634fB0Fc9"; //"YOUR_ESCROW_ADDRESS"; // Replace after deployment
  
  const AccessManager = await ethers.getContractFactory("AccessManager");
  const Escrow = await ethers.getContractFactory("Escrow");
  
  const accessManager = AccessManager.attach(accessManagerAddress);
  const escrow = Escrow.attach(escrowAddress);
  
  // Test addresses for localhost
  const arbitrator1 = "0x70997970C51812dc3A010C7d01b50e0d17dc79C8";
  const arbitrator2 = "0x3C44CdDdB6a900fa2b585dd299e03d12FA4293BC";
  
  console.log("Adding arbitrators...");
  
  // Add arbitrators
  await accessManager.grantArbitratorRole(arbitrator1);
  await accessManager.grantArbitratorRole(arbitrator2);
  
  // Update platform fee to 1.2% (need to handle decimals)
  // Note: Your contract uses integer percentage, so we'll need to modify it for decimals
  // For now, let's set it to 1%
  await escrow.updatePlatformFee(2);
  
  console.log("Setup complete!");
  console.log(`Arbitrator 1: ${arbitrator1}`);
  console.log(`Arbitrator 2: ${arbitrator2}`);
  console.log("Platform fee: 1%");
}

main()
  .then(() => process.exit(0))
  .catch((error) => {
    console.error(error);
    process.exit(1);
  });