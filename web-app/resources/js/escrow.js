'use strict';

import { ethers } from 'ethers';
// import { createWeb3Modal, defaultConfig } from '@reown/walletkit';
import { abi as escrowAbi } from './abi/escrow.json'
// Remove toastr import
// import toastr from 'toastr';
// import 'toastr/build/toastr.min.css';

const CONTRACT_ADDRESS = '0xC80b3735646e9c6a3b15e4AAFf81369fc8E1e7Aa';
const CONTRACT_ABI = escrowAbi;
// const projectId = '18228211cd4cbb14823b4264955cbf1e' // Get this from https://cloud.walletconnect.com

const SUPPORTED_NETWORK = {
    // chainId: 8453, // Base Mainnet
    // name: 'Base Mainnet',
    chainId: 84532, // for Base Sepolia Testnet
    name: 'Base Sepolia',
};

class EscrowApp {
    constructor() {
        this.provider = null;
        this.signer = null;
        this.contract = null;
        this.userAddress = null;
        this.walletType = null;
        this.web3Modal = null;
        this.isConnected = false;
        this.userAgreements = [];
        this.init();
    }

    async init() {
        console.log('🚀 EscrowApp initializing...');
        this.setupEventListeners();
        console.log('✅ EscrowApp initialized');
        // Don't auto-load agreements, wait for wallet connection
        // this.loadUserAgreements();
    }

    setupEventListeners() {
        console.log('🔧 Setting up event listeners...');

        // Remove the connect wallet button listener since walletConnect.js handles it
        // document.getElementById('connect-wallet-btn')?.addEventListener('click', () => this.connectWallet());

        // Create agreement form - try multiple selectors
        let createForm = document.querySelector('#create-agreement-form');
        if (!createForm) {
            createForm = document.querySelector('#create_agreement_modal form');
        }
        if (!createForm) {
            createForm = document.querySelector('form[action="#"]');
        }

        console.log('📝 Form found:', !!createForm, createForm);

        if (createForm) {
            createForm.addEventListener('submit', (e) => {
                console.log('📤 Form submit event triggered');
                this.handleCreateAgreement(e);
            });
            console.log('✅ Form submit listener attached');
        } else {
            console.error('❌ No agreement form found!');
        }

        // Prefill wallet address when modal opens
        const modal = document.getElementById('create_agreement_modal');
        if (modal) {
            modal.addEventListener('show', () => {
                console.log('📋 Modal opened, setting up form...');
                const addressInput = document.getElementById('creator_address_input');
                if (addressInput && window.walletManager && window.walletManager.userAddress) {
                    addressInput.value = window.walletManager.userAddress;
                }
                // Reset feedback
                const feedback = document.getElementById('agreement-create-feedback');
                if (feedback) {
                    feedback.classList.add('hidden');
                    feedback.textContent = '';
                }
                // Reset form
                const form = document.getElementById('create-agreement-form');
                if (form) form.reset();
            });
        }

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleFilter(e));
        });

        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.handleSearch(e));
        }

        // Listen for wallet manager updates
        if (window.walletManager) {
            const originalUpdateUI = window.walletManager.updateUI.bind(window.walletManager);
            window.walletManager.updateUI = function () {
                originalUpdateUI();
                // Update escrow app when wallet connects/disconnects
                if (window.app) {
                    window.app.userAddress = window.walletManager.userAddress;
                    window.app.contract = window.walletManager.contract;
                    if (window.walletManager.isConnected) {
                        window.app.loadUserAgreements();
                    }
                }
            };
        }

        // Agreement creation email-to-wallet logic
        const emailInput = document.getElementById('client_email_input');
        const addressInput = document.getElementById('creator_address_input');
        const errorSpan = document.getElementById('client_email_error');
        const helperSpan = document.getElementById('wallet_address_helper');
        const submitBtn = document.querySelector('#create-agreement-form button[type="submit"]');

        console.log('📧 Setting up email-to-wallet logic:', {
            emailInput: !!emailInput,
            addressInput: !!addressInput,
            errorSpan: !!errorSpan,
            helperSpan: !!helperSpan,
            submitBtn: !!submitBtn
        });

        if (emailInput && addressInput && errorSpan && submitBtn) {
            emailInput.addEventListener('blur', async function () {
                console.log('📧 Email input blur event triggered');
                const email = emailInput.value.trim();
                errorSpan.classList.add('hidden');
                helperSpan.textContent = '';
                addressInput.value = '';
                addressInput.readOnly = true;
                submitBtn.disabled = true;

                if (!email) {
                    console.log('❌ No email provided');
                    return;
                }

                console.log('🔍 Checking wallet for email:', email);

                try {
                    const res = await fetch(`/api/user-wallet-address?email=${encodeURIComponent(email)}`);
                    const data = await res.json();
                    console.log('📡 API response:', data);

                    if (!data.exists) {
                        errorSpan.textContent = 'No user found with this email.';
                        errorSpan.classList.remove('hidden');
                        submitBtn.disabled = true;
                    } else if (!data.wallet_address) {
                        errorSpan.textContent = 'User exists but has not connected a wallet yet.';
                        errorSpan.classList.remove('hidden');
                        submitBtn.disabled = true;
                    } else {
                        addressInput.value = data.wallet_address;
                        addressInput.readOnly = true;
                        errorSpan.classList.add('hidden');
                        helperSpan.textContent = 'Wallet address found and auto-filled.';
                        submitBtn.disabled = false;
                        console.log('✅ Wallet address auto-filled:', data.wallet_address);
                    }
                } catch (e) {
                    console.error('❌ Error checking user wallet address:', e);
                    errorSpan.textContent = 'Error checking user wallet address.';
                    errorSpan.classList.remove('hidden');
                    submitBtn.disabled = true;
                }
            });
            console.log('✅ Email-to-wallet listener attached');
        } else {
            console.warn('⚠️ Email-to-wallet elements not found:', {
                emailInput: !!emailInput,
                addressInput: !!addressInput,
                errorSpan: !!errorSpan,
                submitBtn: !!submitBtn
            });
        }

        console.log('✅ Event listeners setup complete');
    }

    async connectWallet() {
        try {
            // All window.ethereum and MetaMask logic removed for WalletConnect-only flow
            // if (typeof window.ethereum === 'undefined') {
            //     // this.toastrMessage('error', 'MetaMask is not installed. Please install MetaMask to continue.');
            //     return;
            // }

            // await window.ethereum.request({ method: 'eth_requestAccounts' });
            // this.provider = new ethers.BrowserProvider(window.ethereum);
            // this.signer = await this.provider.getSigner();
            // this.userAddress = await this.signer.getAddress();

            // const network = await this.provider.getNetwork();
            // const currentChainId = Number(network.chainId);

            // if (currentChainId !== SUPPORTED_NETWORK.chainId) {
            //     this.toastrMessage('error', `Wrong network! Please switch to ${SUPPORTED_NETWORK.name}`);
            //     await this.promptNetworkSwitch();
            //     return;
            // }

            this.contract = new ethers.Contract(CONTRACT_ADDRESS, CONTRACT_ABI, this.signer);

            // Send to backend
            await fetch('/wallet/connect', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    wallet_address: this.userAddress,
                    wallet_type: 'metamask',
                })
            }).catch(console.error);

            this.updateWalletInfo('Base Sepolia');
            showMessage('Wallet connected successfully!', 'success');
            this.loadUserAgreements();

        } catch (error) {
            console.error('Connection failed:', error);
            showMessage(`Connection failed: ${error.message}`, 'error');
        }
    }

    async promptNetworkSwitch() {
        try {
            // All window.ethereum and MetaMask logic removed for WalletConnect-only flow
            // await window.ethereum.request({
            //     method: 'wallet_switchEthereumChain',
            //     params: [{ chainId: '0x14a34' }],  // 0x2105 Base Mainnet
            // });
            showMessage('Switched to Base Mainnet. Please reconnect.', 'success');
            window.location.reload();
        } catch (switchError) {
            if (switchError.code === 4902) {
                try {
                    // All window.ethereum and MetaMask logic removed for WalletConnect-only flow
                    // await window.ethereum.request({
                    //     method: 'wallet_addEthereumChain',
                    //     params: [{
                    //         // chainId: '0x2105',
                    //         chainId: '0x14a34', // 84532
                    //         chainName: 'Base Sepolia',           // chainName: 'Base',
                    //         nativeCurrency: { name: 'ETH', symbol: 'ETH', decimals: 18 },
                    //         // rpcUrls: ['https://mainnet.base.org'],
                    //         // blockExplorerUrls: ['https://basescan.org'],
                    //         rpcUrls: ['https://sepolia.base.org'],
                    //         blockExplorerUrls: ['https://sepolia.basescan.org'],
                    //     }],
                    // });
                    showMessage('Base network added. Please reconnect.', 'success');
                    window.location.reload();
                } catch (addError) {
                    showMessage('Failed to add network. Please add it manually.', 'error');
                }
            }
        }
    }

    async loadUserAgreements() {
        // Only use the connected wallet address
        if (!window.walletManager || !window.walletManager.userAddress) {
            const agreementsGrid = document.getElementById('agreementsGrid');
            if (agreementsGrid) {
                agreementsGrid.innerHTML = '<div class="col-span-full text-center text-gray-400 py-12">Connect your wallet to view your agreements.</div>';
            }
            return;
        }
        const userAddress = window.walletManager.userAddress;

        this.readOnlyProvider = new ethers.JsonRpcProvider("https://sepolia.base.org"); // or Alchemy
        const contract = new ethers.Contract(CONTRACT_ADDRESS, CONTRACT_ABI, this.readOnlyProvider);
        const currentBlock = await this.readOnlyProvider.getBlockNumber();

        const events = await contract.queryFilter("AgreementCreated", currentBlock - 2000, "latest");
        console.log(events);
        const agreementsGrid = document.getElementById('agreementsGrid');
        if (!agreementsGrid) {
            console.log('Agreements grid not found on this page');
            return;
        }
        agreementsGrid.innerHTML = ''; // Clear previous cards

        const myAgreements = events
            .filter(e =>
                e.args.client.toLowerCase() === userAddress.toLowerCase() ||
                e.args.creator.toLowerCase() === userAddress.toLowerCase()
            )
            .reverse(); // Optional: show most recent first

        const emptyState = document.getElementById('emptyState');
        if (myAgreements.length === 0) {
            if (emptyState) {
                emptyState.style.display = 'block';
            }
            return;
        } else {
            if (emptyState) {
                emptyState.style.display = 'none';
            }
        }

        for (const event of myAgreements) {
            const agreementId = Number(event.args.agreementId);
            const agreement = await contract.agreements(agreementId);

            const card = this.buildAgreementCard({
                id: agreementId,
                title: agreement.description.split(':')[0].trim(),
                description: agreement.description,
                client: agreement.client,
                creator: agreement.creator,
                due_date: agreement.deadline > 0 ? new Date(agreement.deadline * 1000) : null,
                status: this.mapStatus(agreement.status),
                progress: 0, // optional for now
                milestones: agreement.milestones?.length || 0,
                completed_milestones: 0, // for now
                value: ethers.formatEther(agreement.fundedAmount),
            });

            agreementsGrid.appendChild(card);
        }
    }

    buildAgreementCard(data) {
        const card = document.createElement('div');
        card.className = 'agreement-card card bg-base-100 shadow-sm border border-base-200 hover:shadow-lg hover:border-primary/30 transition-all duration-200 cursor-pointer';
        card.dataset.status = data.status;
        card.dataset.title = data.title;
        card.dataset.client = data.client;

        const dueDate = data.due_date
            ? new Date(data.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
            : 'N/A';

        const badgeClass = {
            active: 'badge-primary',
            completed: 'badge-success',
            disputed: 'badge-error',
        }[data.status] || 'badge-neutral';

        card.innerHTML = `
            <div class="card-body">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h3 class="card-title text-lg mb-2">${data.title}</h3>
                        <div class="flex items-center gap-4 text-sm text-base-content/60">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                ${data.client.slice(0, 6)}...${data.client.slice(-4)}
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/></svg>
                                Ξ ${data.value}
                            </div>
                        </div>
                    </div>
                    <div class="badge ${badgeClass}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</div>
                </div>
    
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-base-content/70">Progress</span>
                            <span class="font-medium">${data.completed_milestones}/${data.milestones} milestones</span>
                        </div>
                        <div class="w-full bg-base-200 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: ${data.progress}%"></div>
                        </div>
                    </div>
    
                    <div class="flex items-center justify-between text-sm text-base-content/60">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Due: ${dueDate}
                        </div>
                        <span class="font-medium">${data.progress}% complete</span>
                    </div>
                </div>
            </div>
        `;
        return card;
    }

    mapStatus(index) {
        const statusEnum = ['created', 'funded', 'inprogress', 'disputed', 'completed', 'cancelled'];
        return statusEnum[index] || 'unknown';
    }

    getStatusString(status) {
        const statuses = ['created', 'funded', 'inprogress', 'disputed', 'completed', 'cancelled'];
        return statuses[status] || 'unknown';
    }

    calculateProgress(milestones) {
        if (!milestones || milestones[0].length === 0) return 0;

        const totalMilestones = milestones[0].length;
        const approvedMilestones = milestones[2].filter(status => status === 1).length; // MilestoneStatus.Approved = 1

        return Math.round((approvedMilestones / totalMilestones) * 100);
    }

    async handleCreateAgreement(e) {
        e.preventDefault();
        console.log('🚀 handleCreateAgreement called');
        console.log('window.walletManager:', window.walletManager);
        if (window.walletManager) {
            console.log('isConnected:', window.walletManager.isConnected, 'userAddress:', window.walletManager.userAddress);
        }
        const formData = new FormData(e.target);
        for (let [key, value] of formData.entries()) {
            console.log('Form field:', key, value);
        }
        const creatorEmail = formData.get('client_email');
        const creatorAddress = formData.get('creator_address');
        const title = formData.get('title');
        const description = formData.get('description');
        const dueDate = formData.get('due_date');
        const usdcValue = formData.get('usdc_value');
        const ethValue = formData.get('value'); // Hidden field with converted ETH value
        const feedback = document.getElementById('agreement-create-feedback');
        const submitBtn = e.target.querySelector('button[type="submit"]');

        if (feedback) {
            feedback.classList.add('hidden');
            feedback.textContent = '';
        }
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Creating...';
        }

        if (!creatorAddress || !ethers.isAddress(creatorAddress)) {
            if (feedback) {
                feedback.textContent = 'Invalid or missing creator wallet address.';
                feedback.className = 'text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            } else {
                showMessage('Invalid or missing creator wallet address.', 'error');
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Create Agreement';
            }
            return;
        }

        if (!usdcValue || parseFloat(usdcValue) <= 0) {
            if (feedback) {
                feedback.textContent = 'Please enter a valid USDC amount.';
                feedback.className = 'text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            } else {
                showMessage('Please enter a valid USDC amount.', 'error');
            }
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Create Agreement';
            }
            return;
        }

        // Close the create agreement modal before wallet connect
        const agreementModal = document.getElementById('create_agreement_modal');
        if (agreementModal && agreementModal.open) {
            agreementModal.close();
        }

        // Ensure wallet is connected before proceeding
        if (!window.walletManager || !(await window.walletManager.ensureWalletConnected())) {
            showMessage('Please connect your wallet first', 'error');
            return;
        }

        // Log both addresses before contract call
        console.log('Client (msg.sender):', window.walletManager.userAddress);
        console.log('Creator:', creatorAddress);

        try {
            const deadlineTimestamp = dueDate ? Math.floor(new Date(dueDate).getTime() / 1000) : 0;
            const fullDescription = `${title}: ${description}`;

            if (feedback) {
                feedback.textContent = 'Creating agreement on blockchain...';
                feedback.className = 'text-blue-700 bg-blue-100 border border-blue-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            }

            console.log('Creating agreement with parameters:', {
                creatorAddress,
                fullDescription,
                deadlineTimestamp,
                usdcValue,
                ethValue
            });

            // Validate description length
            if (fullDescription.length < 10) {
                throw new Error('Description must be at least 10 characters long');
            }

            if (fullDescription.length > 1000) {
                throw new Error('Description is too long (max 1000 characters)');
            }

            // Estimate gas first to catch errors early
            console.log('Estimating gas for createAgreement...');
            console.log('Parameters:', {
                creatorAddress,
                fullDescription,
                deadlineTimestamp,
                isTelegramDeal: false,
                telegramChatId: ""
            });

            // Ensure deadline is valid (if 0, set to current time + 30 days)
            const finalDeadline = deadlineTimestamp === 0 ?
                Math.floor(Date.now() / 1000) + (30 * 24 * 60 * 60) :
                deadlineTimestamp;

            // Ensure description is not empty and has minimum length
            if (!fullDescription || fullDescription.trim().length < 5) {
                throw new Error('Description must be at least 5 characters long');
            }

            const gasEstimate = await window.walletManager.contract.createAgreement.estimateGas(
                creatorAddress,
                fullDescription.trim(),
                finalDeadline,
                false, // isTelegramDeal
                "" // telegramChatId (empty for now)
            );

            console.log('Gas estimate:', gasEstimate.toString());

            // Add 20% buffer to gas estimate
            const gasLimit = (gasEstimate * 120n) / 100n;

            // Call the smart contract createAgreement function with explicit gas limit
            const tx = await window.walletManager.contract.createAgreement(
                creatorAddress,
                fullDescription.trim(),
                finalDeadline,
                false, // isTelegramDeal
                "", // telegramChatId (empty for now)
                { gasLimit }
            );

            if (feedback) {
                feedback.textContent = 'Transaction sent, waiting for confirmation...';
                feedback.className = 'text-blue-700 bg-blue-100 border border-blue-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            }

            const receipt = await tx.wait();

            if (feedback) {
                feedback.textContent = 'Agreement created successfully!';
                feedback.className = 'text-green-700 bg-green-100 border border-green-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            }

            // Close modal after short delay
            setTimeout(() => {
                const modal = document.getElementById('create_agreement_modal');
                if (modal) modal.close();
                if (feedback) {
                    feedback.classList.add('hidden');
                    feedback.textContent = '';
                }
            }, 2000);

            // Reload agreements
            await this.loadUserAgreements();

        } catch (error) {
            console.error('Create agreement failed:', error);

            // Provide more specific error messages
            let errorMessage = 'Failed to create agreement';

            if (error.message.includes('missing revert data')) {
                errorMessage = 'Smart contract error: Please check your wallet connection and try again. This might be due to insufficient gas or invalid parameters.';
            } else if (error.message.includes('insufficient funds')) {
                errorMessage = 'Insufficient funds in wallet for gas fees';
            } else if (error.message.includes('user rejected')) {
                errorMessage = 'Transaction was cancelled by user';
            } else if (error.message.includes('Description must be at least')) {
                errorMessage = error.message;
            } else if (error.message.includes('Description is too long')) {
                errorMessage = error.message;
            } else if (error.message.includes('Invalid creator address')) {
                errorMessage = 'Invalid creator wallet address';
            } else if (error.message.includes('Client and creator cannot be the same')) {
                errorMessage = 'You cannot create an agreement with yourself';
            } else {
                errorMessage = error.message || 'Unknown error occurred';
            }

            if (feedback) {
                feedback.textContent = errorMessage;
                feedback.className = 'text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3';
                feedback.classList.remove('hidden');
            } else {
                showMessage(errorMessage, 'error');
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg> Create Agreement';
            }
        }
    }
}

// Initialize the app when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Initializing EscrowApp...');
    const app = new EscrowApp();
    window.app = app; // Make accessible for onclick handlers
    console.log('✅ EscrowApp initialized');
});

// Add showMessage function if not already defined
if (!window.showMessage) {
    window.showMessage = function (message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} fixed top-4 right-4 z-50 max-w-sm shadow-lg`;
        alert.innerHTML = `
            <div>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(alert);
        setTimeout(() => {
            alert.remove();
        }, 5000);
    };
}