import { ethers } from 'ethers';
import EthereumProvider from '@walletconnect/ethereum-provider';
import { abi as escrowAbi } from './abi/escrow.json';

const PROJECT_ID = '18228211cd4cbb14823b4264955cbf1e';
const BASE_SEPOLIA_CHAIN_ID = 84532;
const BASE_SEPOLIA_RPC = 'https://base-sepolia.g.alchemy.com/v2/e6eIQ646n2qK6NsodvAWI';
const CONTRACT_ADDRESS = '0x9E842E7bbEb02B5F278d415B30e5dBb5279A79b9';

class WalletManager {
    constructor() {
        this.provider = null;
        this.signer = null;
        this.userAddress = null;
        this.walletType = null;
        this.walletConnectProvider = null;
        this.isConnected = false;
        this.contract = null;
        this.isInitializing = false;
        this.autoConnectAttempted = false;
    }

    async init() {
        if (this.isInitializing) return;
        this.isInitializing = true;

        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.setupEventListeners();
                this.autoConnect();
            });
        } else {
            this.setupEventListeners();
            await this.autoConnect();
        }
    }

    setupEventListeners() {
        // Connect Wallet button
        const connectBtn = document.getElementById('connect-wallet-btn');
        if (connectBtn) {
            connectBtn.addEventListener('click', () => {
                this.showWalletModal();
            });
        }

        // Disconnect wallet button
        const disconnectBtn = document.getElementById('disconnect-wallet');
        if (disconnectBtn) {
            disconnectBtn.addEventListener('click', () => {
                this.disconnectWallet();
            });
        }

        // WalletConnect button
        const walletConnectBtn = document.getElementById('walletconnect-btn');
        if (walletConnectBtn) {
            walletConnectBtn.addEventListener('click', () => {
                this.connectWalletConnect();
            });
        }

        // MetaMask button
        const metamaskBtn = document.getElementById('metamask-btn');
        if (metamaskBtn) {
            metamaskBtn.addEventListener('click', () => {
                this.connectMetaMask();
            });
        }

        // Close modal
        const closeModal = document.getElementById('close-modal');
        if (closeModal) {
            closeModal.addEventListener('click', () => {
                this.hideWalletModal();
            });
        }

        // Backdrop click to close modal
        const modal = document.getElementById('wallet-modal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.hideWalletModal();
                }
            });
        }
    }

    async autoConnect() {
        if (this.autoConnectAttempted) return;
        this.autoConnectAttempted = true;

        console.log('🔄 Attempting auto-connect...');

        try {
            const savedWalletType = localStorage.getItem('walletType');
            const savedAddress = localStorage.getItem('walletAddress');

            console.log('📦 Saved wallet data:', { type: savedWalletType, address: savedAddress });

            if (!savedWalletType || !savedAddress) {
                console.log('❌ No saved wallet data found');
                this.updateUI();
                return;
            }

            // Try to auto-connect without showing any popups
            if (savedWalletType === 'MetaMask' && typeof window.ethereum !== 'undefined') {
                console.log('🔗 Attempting MetaMask auto-connect...');
                await this.autoConnectMetaMask();
            } else if (savedWalletType === 'WalletConnect') {
                console.log('🔗 Attempting WalletConnect auto-connect...');
                await this.autoConnectWalletConnect();
            } else {
                console.log('❌ Wallet type not supported or ethereum not available');
            }
        } catch (error) {
            console.log('❌ Auto-connect failed:', error.message);
            this.clearStoredWallet();
        } finally {
            this.updateUI();
        }
    }

    async checkNetwork() {
        if (!this.provider) return false;

        try {
            const network = await this.provider.getNetwork();
            const isCorrectNetwork = network.chainId === BigInt(BASE_SEPOLIA_CHAIN_ID);

            if (!isCorrectNetwork) {
                this.showErrorMessage(`Please switch to Base Sepolia network (Chain ID: ${BASE_SEPOLIA_CHAIN_ID})`);
                return false;
            }

            return true;
        } catch (error) {
            console.error('Network check failed:', error);
            return false;
        }
    }

    async autoConnectMetaMask() {
        try {
            // Only check for existing accounts, do not prompt
            const accounts = await window.ethereum.request({ method: 'eth_accounts' });
            if (accounts.length === 0) {
                console.log('❌ No MetaMask accounts found');
                return;
            }

            console.log('✅ MetaMask accounts found:', accounts);

            // Check network
            const chainId = await window.ethereum.request({ method: 'eth_chainId' });
            const currentChainId = parseInt(chainId, 16);
            console.log('🌐 Current chain ID:', currentChainId, 'Expected:', BASE_SEPOLIA_CHAIN_ID);

            if (currentChainId !== BASE_SEPOLIA_CHAIN_ID) {
                console.log('⚠️ Wrong network, attempting to switch...');
                await this.switchToBaseSepolia();
            }

            this.provider = new ethers.BrowserProvider(window.ethereum);
            this.signer = await this.provider.getSigner();
            this.userAddress = await this.signer.getAddress();

            // Listen for account and chain changes
            window.ethereum.on('accountsChanged', (accounts) => {
                console.log('🔄 MetaMask accountsChanged event:', accounts);
                this.disconnectWallet();
            });
            window.ethereum.on('chainChanged', (chainId) => {
                console.log('🔄 MetaMask chainChanged event:', chainId);
                this.disconnectWallet();
            });

            // Verify it's the same address
            if (this.userAddress.toLowerCase() !== localStorage.getItem('walletAddress').toLowerCase()) {
                throw new Error('Wallet address changed');
            }

            this.walletType = 'MetaMask';
            this.isConnected = true;
            this.contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, this.signer);

            console.log('✅ MetaMask auto-connected successfully');
        } catch (error) {
            console.log('❌ Auto-connect failed:', error.message);
            this.clearStoredWallet();
        }
    }

    async autoConnectWalletConnect() {
        try {
            this.walletConnectProvider = await EthereumProvider.init({
                projectId: PROJECT_ID,
                chains: [BASE_SEPOLIA_CHAIN_ID],
                rpcMap: {
                    [BASE_SEPOLIA_CHAIN_ID]: BASE_SEPOLIA_RPC,
                },
                showQrModal: false, // Never show QR modal for auto-connect
            });

            // Only restore if session exists
            if (!this.walletConnectProvider.session) {
                throw new Error('No existing WalletConnect session');
            }

            this.provider = new ethers.BrowserProvider(this.walletConnectProvider);
            this.signer = await this.provider.getSigner();
            this.userAddress = await this.signer.getAddress();

            // Verify it's the same address
            if (this.userAddress.toLowerCase() !== localStorage.getItem('walletAddress').toLowerCase()) {
                throw new Error('Wallet address changed');
            }

            this.walletType = 'WalletConnect';
            this.isConnected = true;
            this.contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, this.signer);

            // Set up listeners
            this.walletConnectProvider.on('disconnect', () => {
                this.disconnectWallet();
            });

            console.log('Auto-connected to WalletConnect');
            this.triggerAppUpdate();
        } catch (error) {
            this.clearStoredWallet();
        }
    }

    // Helper: Ensure wallet is connected before on-chain action
    async ensureWalletConnected() {
        if (this.isConnected && this.userAddress && this.signer) {
            return true;
        }
        // Show wallet modal and wait for connection
        return new Promise((resolve) => {
            const onConnect = () => {
                if (this.isConnected) {
                    window.removeEventListener('walletConnected', onConnect);
                    resolve(true);
                }
            };
            window.addEventListener('walletConnected', onConnect);
            this.showWalletModal();
        });
    }

    // Patch connectMetaMask and connectWalletConnect to dispatch walletConnected event
    async connectMetaMask() {
        if (typeof window.ethereum === 'undefined') {
            this.showErrorMessage('MetaMask is not installed. Please install MetaMask to continue.');
            return;
        }

        try {
            await window.ethereum.request({ method: 'eth_requestAccounts' });
            await this.checkAndSwitchNetwork();
            this.provider = new ethers.BrowserProvider(window.ethereum);
            this.signer = await this.provider.getSigner();
            this.userAddress = await this.signer.getAddress();
            this.walletType = 'MetaMask';
            this.isConnected = true;
            this.contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, this.signer);
            await this.saveWallet();
            this.updateUI();
            this.hideWalletModal();
            this.showSuccessMessage('MetaMask connected successfully!');
            this.triggerAppUpdate();
            window.dispatchEvent(new Event('walletConnected'));
            window.walletManager = this;
            window.walletManager.updateUI();
            if (window.updateWalletHeader) window.updateWalletHeader(this.userAddress);
        } catch (error) {
            console.error('MetaMask connection error:', error);
            this.showErrorMessage(`Failed to connect MetaMask: ${error.message}`);
        }
    }

    async connectWalletConnect() {
        try {
            this.walletConnectProvider = await EthereumProvider.init({
                projectId: PROJECT_ID,
                chains: [BASE_SEPOLIA_CHAIN_ID],
                rpcMap: {
                    [BASE_SEPOLIA_CHAIN_ID]: BASE_SEPOLIA_RPC,
                },
                showQrModal: true,
            });
            await this.walletConnectProvider.enable();
            this.provider = new ethers.BrowserProvider(this.walletConnectProvider);
            this.signer = await this.provider.getSigner();
            this.userAddress = await this.signer.getAddress();
            this.walletType = 'WalletConnect';
            this.isConnected = true;
            this.contract = new ethers.Contract(CONTRACT_ADDRESS, escrowAbi, this.signer);
            await this.saveWallet();
            this.updateUI();
            this.hideWalletModal();
            this.showSuccessMessage('WalletConnect connected successfully!');
            this.triggerAppUpdate();
            window.dispatchEvent(new Event('walletConnected'));
            window.walletManager = this;
            window.walletManager.updateUI();
            if (window.updateWalletHeader) window.updateWalletHeader(this.userAddress);
            this.walletConnectProvider.on('disconnect', () => {
                this.disconnectWallet();
            });
        } catch (error) {
            console.error('WalletConnect connection error:', error);
            this.showErrorMessage(`Failed to connect WalletConnect: ${error.message}`);
        }
    }

    async switchToBaseSepolia() {
        try {
            await window.ethereum.request({
                method: 'wallet_switchEthereumChain',
                params: [{ chainId: `0x${BASE_SEPOLIA_CHAIN_ID.toString(16)}` }],
            });
        } catch (switchError) {
            // If the network doesn't exist, add it
            if (switchError.code === 4902) {
                await window.ethereum.request({
                    method: 'wallet_addEthereumChain',
                    params: [{
                        chainId: `0x${BASE_SEPOLIA_CHAIN_ID.toString(16)}`,
                        chainName: 'Base Sepolia',
                        nativeCurrency: {
                            name: 'ETH',
                            symbol: 'ETH',
                            decimals: 18
                        },
                        rpcUrls: [BASE_SEPOLIA_RPC],
                        blockExplorerUrls: ['https://sepolia.basescan.org/']
                    }],
                });
            } else {
                throw switchError;
            }
        }
    }

    async checkAndSwitchNetwork() {
        if (!this.isConnected || this.walletType !== 'MetaMask') return;

        try {
            const chainId = await window.ethereum.request({ method: 'eth_chainId' });
            if (parseInt(chainId, 16) !== BASE_SEPOLIA_CHAIN_ID) {
                this.showErrorMessage('Please switch to Base Sepolia network');
                await this.switchToBaseSepolia();
            }
        } catch (error) {
            console.error('Network check failed:', error);
        }
    }

    showWalletModal() {
        // Only show modal if not already connected
        if (this.isConnected) {
            this.showMessage('Wallet already connected', 'info');
            return;
        }

        const modal = document.getElementById('wallet-modal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    hideWalletModal() {
        const modal = document.getElementById('wallet-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    async saveWallet() {
        // Save to localStorage
        localStorage.setItem('walletType', this.walletType);
        localStorage.setItem('walletAddress', this.userAddress);

        // Save to backend
        try {
            const response = await fetch('/wallet/connect', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify({
                    wallet_address: this.userAddress,
                    wallet_type: this.walletType
                })
            });

            if (!response.ok) {
                console.warn('Failed to save wallet to backend');
            }
        } catch (error) {
            console.warn('Backend save failed:', error);
        }
    }

    async clearWalletFromBackend() {
        try {
            const response = await fetch('/wallet/disconnect', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                }
            });

            if (!response.ok) {
                console.warn('Failed to clear wallet from backend');
            }
        } catch (error) {
            console.warn('Backend clear failed:', error);
        }
    }

    async disconnectWallet() {
        try {
            if (this.walletConnectProvider && this.walletType === 'WalletConnect') {
                await this.walletConnectProvider.disconnect();
                this.walletConnectProvider = null;
            }

            this.provider = null;
            this.signer = null;
            this.userAddress = null;
            this.walletType = null;
            this.isConnected = false;
            this.contract = null;

            this.clearStoredWallet();
            await this.clearWalletFromBackend();
            this.updateUI();
            this.showSuccessMessage('Wallet disconnected successfully!');

            // Clear app state
            if (window.app) {
                window.app.userAddress = null;
                window.app.userAgreements = [];
                window.app.renderAgreements();
            }
            if (window.updateWalletHeader) window.updateWalletHeader(null);
        } catch (error) {
            console.error('Disconnect error:', error);
        }
    }

    clearStoredWallet() {
        localStorage.removeItem('walletType');
        localStorage.removeItem('walletAddress');
    }

    triggerAppUpdate() {
        // Update app with new wallet connection
        if (window.app && this.userAddress) {
            window.app.userAddress = this.userAddress;
            if (window.app.loadUserAgreements) {
                window.app.loadUserAgreements();
            }
        }

        // Update trust score panel
        this.updateTrustScorePanel();
    }

    updateTrustScorePanel() {
        if (this.userAddress) {
            this.getTrustScore().then(score => {
                const trustScoreEl = document.getElementById('trust-score-value');
                if (trustScoreEl) {
                    trustScoreEl.textContent = score;
                }
            });
        }
    }

    updateUI() {
        const connectBtn = document.getElementById('connect-wallet-btn');
        const disconnectBtn = document.getElementById('disconnect-wallet');
        const walletInfo = document.getElementById('wallet-info');
        const walletAddress = document.getElementById('wallet-address');
        const copyBtn = document.getElementById('copy-address');

        if (this.isConnected && this.userAddress) {
            // Show connected state
            if (connectBtn) connectBtn.style.display = 'none';
            if (disconnectBtn) disconnectBtn.style.display = 'block';
            if (walletInfo) walletInfo.style.display = 'flex';
            if (walletAddress) {
                walletAddress.textContent = `${this.userAddress.slice(0, 6)}...${this.userAddress.slice(-4)}`;
                walletAddress.title = this.userAddress;
            }
            if (copyBtn) {
                copyBtn.onclick = () => this.copyAddress();
            }
        } else {
            // Show disconnected state
            if (connectBtn) connectBtn.style.display = 'block';
            if (disconnectBtn) disconnectBtn.style.display = 'none';
            if (walletInfo) walletInfo.style.display = 'none';
        }
    }

    async copyAddress() {
        if (this.userAddress) {
            try {
                await navigator.clipboard.writeText(this.userAddress);
                this.showSuccessMessage('Address copied to clipboard!');
            } catch (error) {
                console.error('Failed to copy address:', error);
                this.showErrorMessage('Failed to copy address');
            }
        }
    }

    async getTrustScore() {
        if (!this.contract || !this.userAddress) return 0;

        try {
            const score = await this.contract.getUserReputationScore(this.userAddress);
            return score.toString();
        } catch (error) {
            console.error('Failed to get trust score:', error);
            return 0;
        }
    }

    async getTrustScoreForAddress(address) {
        if (!this.contract) return 0;

        try {
            const score = await this.contract.getUserReputationScore(address);
            return score.toString();
        } catch (error) {
            console.error('Failed to get trust score for address:', error);
            return 0;
        }
    }

    showSuccessMessage(message) {
        this.showMessage(message, 'success');
    }

    showErrorMessage(message) {
        this.showMessage(message, 'error');
    }

    showMessage(message, type = 'info') {
        // Use the existing toast system
        if (window.showMessage) {
            window.showMessage(message, type);
        } else {
            console.log(`${type}: ${message}`);
        }
    }
}

// Initialize wallet manager
const walletManager = new WalletManager();
window.walletManager = walletManager;

// Auto-initialize when script loads
walletManager.init();

export default walletManager;
