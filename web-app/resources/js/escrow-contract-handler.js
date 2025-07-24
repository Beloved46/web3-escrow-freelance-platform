'use strict';

import { ethers } from 'ethers';

import { abi as escrowAbi } from './abi/escrow.json'

const CONTRACT_ADDRESS = '0xC80b3735646e9c6a3b15e4AAFf81369fc8E1e7Aa';


class EscrowContractHandler {
    constructor(contractAddress, contractABI) {
        this.contractAddress = contractAddress;
        this.contractABI = contractABI;
        this.provider = null;
        this.signer = null;
        this.contract = null;
        this.userAddress = null;
    }

    /**
     * Initialize Web3 connection and connect to MetaMask
     */
    async connectWallet() {
        try {
            // Check if MetaMask is installed
            if (typeof window.ethereum === 'undefined') {
                throw new Error('MetaMask is not installed. Please install MetaMask to continue.');
            }

            // Request account access
            await window.ethereum.request({ method: 'eth_requestAccounts' });

            // Create provider and signer
            this.provider = new ethers.providers.Web3Provider(window.ethereum);
            this.signer = this.provider.getSigner();
            this.userAddress = await this.signer.getAddress();

            // Initialize contract instance
            this.contract = new ethers.Contract(this.contractAddress, this.contractABI, this.signer);

            // Check if we're on the correct network (Base network example)
            const network = await this.provider.getNetwork();
            const expectedChainId = 8453; // Base Mainnet - change as needed

            if (network.chainId !== expectedChainId) {
                await this.switchNetwork(expectedChainId);
            }

            console.log('Wallet connected:', this.userAddress);
            return {
                success: true,
                address: this.userAddress,
                network: network.name
            };

        } catch (error) {
            console.error('Wallet connection failed:', error);
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Switch to the correct network
     */
    async switchNetwork(chainId) {
        try {
            await window.ethereum.request({
                method: 'wallet_switchEthereumChain',
                params: [{ chainId: `0x${chainId.toString(16)}` }],
            });
        } catch (switchError) {
            // This error code indicates that the chain has not been added to MetaMask
            if (switchError.code === 4902) {
                await this.addNetwork(chainId);
            } else {
                throw switchError;
            }
        }
    }

    /**
     * Add network to MetaMask (example for Base)
     */
    async addNetwork(chainId) {
        const networkConfigs = {
            8453: { // Base Mainnet
                chainId: '0x2105',
                chainName: 'Base',
                nativeCurrency: { name: 'ETH', symbol: 'ETH', decimals: 18 },
                rpcUrls: ['https://mainnet.base.org'],
                blockExplorerUrls: ['https://basescan.org']
            },
            84532: { // Base Sepolia Testnet
                chainId: '0x14a34',
                chainName: 'Base Sepolia',
                nativeCurrency: { name: 'ETH', symbol: 'ETH', decimals: 18 },
                rpcUrls: ['https://sepolia.base.org'],
                blockExplorerUrls: ['https://sepolia.basescan.org']
            }
        };

        const config = networkConfigs[chainId];
        if (!config) {
            throw new Error(`Network configuration not found for chain ID: ${chainId}`);
        }

        await window.ethereum.request({
            method: 'wallet_addEthereumChain',
            params: [config],
        });
    }

    /**
     * Create a new agreement
     * @param {string} creatorAddress - Creator's wallet address
     * @param {string} description - Agreement description
     * @param {number} deadlineTimestamp - Deadline timestamp (0 for no deadline)
     */
    async createAgreement(creatorAddress, description, deadlineTimestamp = 0) {
        try {
            if (!this.contract) {
                throw new Error('Contract not initialized. Please connect wallet first.');
            }

            // Validate inputs
            if (!ethers.utils.isAddress(creatorAddress)) {
                throw new Error('Invalid creator address');
            }

            if (!description.trim()) {
                throw new Error('Description cannot be empty');
            }

            // Call the smart contract function
            const tx = await this.contract.createAgreement(
                creatorAddress,
                description,
                deadlineTimestamp
            );

            console.log('Transaction sent:', tx.hash);

            // Wait for transaction confirmation
            const receipt = await tx.wait();
            console.log('Transaction confirmed:', receipt);

            // Extract agreement ID from event logs
            const agreementCreatedEvent = receipt.events?.find(
                event => event.event === 'AgreementCreated'
            );

            const agreementId = agreementCreatedEvent?.args?.agreementId?.toString();

            return {
                success: true,
                agreementId: agreementId,
                transactionHash: tx.hash,
                blockNumber: receipt.blockNumber
            };

        } catch (error) {
            console.error('Create agreement failed:', error);
            return {
                success: false,
                error: error.message || 'Transaction failed'
            };
        }
    }

    /**
     * Get agreement details
     * @param {number} agreementId - Agreement ID
     */
    async getAgreement(agreementId) {
        try {
            if (!this.contract) {
                throw new Error('Contract not initialized');
            }

            const agreement = await this.contract.agreements(agreementId);

            return {
                success: true,
                agreement: {
                    id: agreementId,
                    client: agreement.client,
                    creator: agreement.creator,
                    description: agreement.description,
                    totalAmount: ethers.utils.formatEther(agreement.totalAmount),
                    platformFee: ethers.utils.formatEther(agreement.platformFee),
                    createdAt: new Date(agreement.createdAt.toNumber() * 1000),
                    deadline: agreement.deadline.toNumber() === 0 ? null : new Date(agreement.deadline.toNumber() * 1000),
                    status: agreement.status,
                    fundedAmount: ethers.utils.formatEther(agreement.fundedAmount),
                    releasedAmount: ethers.utils.formatEther(agreement.releasedAmount)
                }
            };

        } catch (error) {
            console.error('Get agreement failed:', error);
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Listen to contract events
     */
    setupEventListeners() {
        if (!this.contract) {
            console.error('Contract not initialized');
            return;
        }

        // Listen for AgreementCreated events
        this.contract.on('AgreementCreated', (agreementId, client, creator, totalAmount, event) => {
            console.log('New agreement created:', {
                agreementId: agreementId.toString(),
                client,
                creator,
                totalAmount: ethers.utils.formatEther(totalAmount)
            });

            // Dispatch custom event for UI to handle
            window.dispatchEvent(new CustomEvent('agreementCreated', {
                detail: { agreementId: agreementId.toString(), client, creator, totalAmount }
            }));
        });

        // Listen for other events as needed
        this.contract.on('AgreementFunded', (agreementId, amount, event) => {
            console.log('Agreement funded:', {
                agreementId: agreementId.toString(),
                amount: ethers.utils.formatEther(amount)
            });
        });
    }

    /**
     * Get user's current account
     */
    getCurrentAccount() {
        return this.userAddress;
    }

    /**
     * Check if wallet is connected
     */
    isConnected() {
        return this.userAddress !== null;
    }

    /**
     * Format address for display (0x1234...5678)
     */
    static formatAddress(address) {
        if (!address) return '';
        return `${address.substring(0, 6)}...${address.substring(address.length - 4)}`;
    }

    /**
     * Convert date to timestamp
     */
    static dateToTimestamp(date) {
        return Math.floor(new Date(date).getTime() / 1000);
    }
}

// Export for use in other modules
export default EscrowContractHandler;