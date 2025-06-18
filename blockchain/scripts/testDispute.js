async function main() {
    const [deployer, client, creator, arbitrator1] = await ethers.getSigners();
    
    // Replace with your deployed addresses
    const escrowAddress = "YOUR_ESCROW_ADDRESS_HERE";
    const accessManagerAddress = "YOUR_ACCESS_MANAGER_ADDRESS_HERE";
    
    const Escrow = await ethers.getContractFactory("Escrow");
    const AccessManager = await ethers.getContractFactory("AccessManager");
    
    const escrow = Escrow.attach(escrowAddress);
    const accessManager = AccessManager.attach(accessManagerAddress);
    
    console.log("=== TESTING DISPUTE RESOLUTION ===\n");
    
    // Setup: Create and fund an agreement
    console.log("1. Setting up dispute scenario...");
    const tx1 = await escrow.connect(client).createAgreement(
      creator.address,
      "Logo design project",
      0 // No deadline
    );
    await tx1.wait();
    
    const agreementId = 2; // Assuming this is the second agreement
    
    await escrow.connect(client).addMilestone(
      agreementId,
      "Initial logo concepts",
      ethers.parseEther("1.0")
    );
    
    await escrow.connect(client).fundAgreement(agreementId, { 
      value: ethers.parseEther("1.0") 
    });
    
    console.log("✅ Agreement created and funded");
    
    // Test dispute initiation
    console.log("\n2. Creator initiating dispute...");
    await escrow.connect(creator).initiateDispute(
      agreementId, 
      "Client is not responding to messages and milestone requirements are unclear"
    );
    console.log("✅ Dispute initiated");
    
    // Check dispute status
    const agreement = await escrow.getAgreement(agreementId);
    const disputeId = agreement.disputeId;
    console.log(`📋 Dispute ID: ${disputeId}`);
    console.log(`📋 Agreement Status: ${agreement.status}`); // Should be 3 (Disputed)
    
    // Assign arbitrator (only admin can do this)
    console.log("\n3. Assigning arbitrator...");
    await escrow.connect(deployer).assignArbitrator(disputeId, arbitrator1.address);
    console.log(`✅ Arbitrator assigned: ${arbitrator1.address}`);
    
    // Verify arbitrator role
    const isArbitrator = await accessManager.isArbitrator(arbitrator1.address);
    console.log(`📋 Is valid arbitrator: ${isArbitrator}`);
    
    // Resolve dispute in favor of creator
    console.log("\n4. Resolving dispute in favor of creator...");
    const refundAmount = ethers.parseEther("0.95"); // 95% to creator, 5% kept as platform fee
    
    await escrow.connect(arbitrator1).resolveDispute(
      disputeId,
      agreementId, 
      creator.address, // Winner
      [refundAmount] // Amount to pay to winner
    );
    
    console.log("✅ Dispute resolved in favor of creator");
    
    // Check final status
    const finalAgreement = await escrow.getAgreement(agreementId);
    console.log(`📊 Final Status: ${finalAgreement.status}`);
    console.log(`📊 Released Amount: ${ethers.formatEther(finalAgreement.releasedAmount)} ETH`);
    
    console.log("\n=== DISPUTE TEST COMPLETE ===");
  }
  
  main()
    .then(() => process.exit(0))
    .catch((error) => {
      console.error(error);
      process.exit(1);
    });