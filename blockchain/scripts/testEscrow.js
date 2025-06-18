async function main() {
    // Get signers (test accounts)
    const [deployer, client, creator, arbitrator1] = await ethers.getSigners();
    
    // Replace with your deployed contract address
    const escrowAddress = "0xCf7Ed3AccA5a467e9e704C703E8D87F634fB0Fc9"; //"YOUR_ESCROW_ADDRESS_HERE";
    
    const Escrow = await ethers.getContractFactory("Escrow");
    const escrow = Escrow.attach(escrowAddress);
    
    console.log("=== ESCROW CONTRACT TESTING ===\n");
    
    // Test 1: Create Agreement
    console.log("1. Creating agreement...");
    const tx1 = await escrow.connect(client).createAgreement(
      creator.address,
      "Build a website with React and Node.js",
      Math.floor(Date.now() / 1000) + 30 * 24 * 60 * 60 // 30 days deadline
    );
    const receipt1 = await tx1.wait();
    const agreementId = 1; // First agreement will have ID 1
    console.log(`✅ Agreement created with ID: ${agreementId}`);
    
    // Test 2: Add Milestones
    console.log("\n2. Adding milestones...");
    await escrow.connect(client).addMilestone(
      agreementId,
      "Frontend development - React components",
      ethers.parseEther("2.0")
    );
    console.log("✅ Milestone 1 added: Frontend (2 ETH)");
    
    await escrow.connect(client).addMilestone(
      agreementId,
      "Backend development - API endpoints", 
      ethers.parseEther("1.5")
    );
    console.log("✅ Milestone 2 added: Backend (1.5 ETH)");
    
    await escrow.connect(creator).addMilestone(
      agreementId,
      "Testing and deployment",
      ethers.parseEther("0.5")
    );
    console.log("✅ Milestone 3 added: Testing (0.5 ETH)");
    
    // Test 3: Fund Agreement
    console.log("\n3. Funding agreement...");
    const fundingAmount = ethers.parseEther("4.0"); // Total of all milestones
    await escrow.connect(client).fundAgreement(agreementId, { value: fundingAmount });
    console.log(`✅ Agreement funded with ${ethers.formatEther(fundingAmount)} ETH`);
    
    // Test 4: Check Agreement Details
    console.log("\n4. Getting agreement details...");
    const agreement = await escrow.getAgreement(agreementId);
    console.log(`📋 Client: ${agreement.client}`);
    console.log(`📋 Creator: ${agreement.creator}`);
    console.log(`📋 Total Amount: ${ethers.formatEther(agreement.totalAmount)} ETH`);
    console.log(`📋 Funded Amount: ${ethers.formatEther(agreement.fundedAmount)} ETH`);
    console.log(`📋 Status: ${agreement.status}`); // 1 = Funded
    console.log(`📋 Milestones Count: ${agreement.milestonesCount}`);
    
    // Test 5: Get All Milestones
    console.log("\n5. Getting all milestones...");
    const milestones = await escrow.getAllMilestones(agreementId);
    for (let i = 0; i < milestones.descriptions.length; i++) {
      console.log(`📝 Milestone ${i}: ${milestones.descriptions[i]}`);
      console.log(`   Amount: ${ethers.formatEther(milestones.amounts[i])} ETH`);
      console.log(`   Status: ${milestones.statuses[i]}`); // 0 = Pending
    }
    
    // Test 6: Creator Completes Milestone
    console.log("\n6. Creator completing first milestone...");
    await escrow.connect(creator).completeMilestone(agreementId, 0);
    console.log("✅ Milestone 0 marked as completed");
    
    // Test 7: Client Approves Milestone
    console.log("\n7. Client approving first milestone...");
    const balanceBefore = await ethers.provider.getBalance(creator.address);
    await escrow.connect(client).approveMilestone(agreementId, 0);
    const balanceAfter = await ethers.provider.getBalance(creator.address);
    const earned = balanceAfter - balanceBefore;
    console.log(`✅ Milestone approved! Creator earned: ${ethers.formatEther(earned)} ETH`);
    
    // Test 8: Creator Completes Second Milestone but Client Rejects
    console.log("\n8. Testing milestone rejection...");
    await escrow.connect(creator).completeMilestone(agreementId, 1);
    await escrow.connect(client).rejectMilestone(agreementId, 1, "Code quality doesn't meet requirements");
    console.log("✅ Milestone 1 rejected by client");
    
    // Test 9: Check Updated Agreement
    console.log("\n9. Final agreement status...");
    const updatedAgreement = await escrow.getAgreement(agreementId);
    console.log(`📊 Funded Amount: ${ethers.formatEther(updatedAgreement.fundedAmount)} ETH`);
    console.log(`📊 Released Amount: ${ethers.formatEther(updatedAgreement.releasedAmount)} ETH`);
    
    console.log("\n=== TESTING COMPLETE ===");
  }
  
  main()
    .then(() => process.exit(0))
    .catch((error) => {
      console.error(error);
      process.exit(1);
    });