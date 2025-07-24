async function main() {
    const [deployer] = await ethers.getSigners();
    console.log("Deploying with account:", deployer.address);
  
    const Escrow = await ethers.getContractFactory("Escrow");
    const escrow = await Escrow.deploy(/* constructor args here */);
    await escrow.deployed();
  
    console.log("✅ Escrow deployed at:", escrow.address);
  }
  
  main().catch((error) => {
    console.error(error);
    process.exit(1);
  });
  