'use strict';

import './agreement.js';
// import './milestone.js';
// import './funding.js';
// import './connect.js';

import './walletConnect.js';
import './escrow.js';
import './dashboard.js';
import './usdc-converter.js';
import './agreement-form-handler.js';

// Initialize everything when DOM is loaded
window.addEventListener('DOMContentLoaded', async () => {
    console.log('🚀 Initializing Bondr application...');

    // Wait for wallet manager to be ready
    if (window.walletManager) {
        console.log('✅ Wallet manager found');

        // Initialize escrow app if not already done
        if (!window.app) {
            console.log('🔧 Initializing escrow app...');
            window.app = new EscrowApp();
        }

        // Ensure wallet manager triggers app updates
        const originalTriggerAppUpdate = window.walletManager.triggerAppUpdate.bind(window.walletManager);
        window.walletManager.triggerAppUpdate = function () {
            console.log('🔄 Triggering app update...');
            originalTriggerAppUpdate();

            // Update escrow app
            if (window.app) {
                window.app.userAddress = window.walletManager.userAddress;
                window.app.contract = window.walletManager.contract;
                if (window.walletManager.isConnected && window.app.loadUserAgreements) {
                    window.app.loadUserAgreements();
                }
            }
        };

        // Update UI immediately
        window.walletManager.updateUI();

    } else {
        console.error('❌ Wallet manager not found!');
    }

    // Trust Score Panel Dynamic Update
    const scoreValue = document.getElementById('trust-score-value');
    const scoreLabel = document.getElementById('trust-score-label');
    const scoreBar = document.getElementById('trust-score-bar');
    if (scoreValue && window.walletManager) {
        async function updateTrustScore() {
            if (window.walletManager.isConnected) {
                const score = await window.walletManager.getTrustScore();
                if (score !== null) {
                    scoreValue.textContent = score;
                    scoreLabel.textContent = `${score}/100`;
                    scoreBar.style.width = `${score}%`;
                } else {
                    scoreValue.textContent = '--';
                    scoreLabel.textContent = '--/100';
                    scoreBar.style.width = '0%';
                }
            } else {
                scoreValue.textContent = '--';
                scoreLabel.textContent = '--/100';
                scoreBar.style.width = '0%';
            }
        }
        // Update on wallet connect/disconnect
        const origUpdateUI = window.walletManager.updateUI.bind(window.walletManager);
        window.walletManager.updateUI = function () {
            origUpdateUI();
            updateTrustScore();
        };
        // Initial fetch
        updateTrustScore();
    }

    // Add wallet header update logic
    window.updateWalletHeader = function (address) {
        const container = document.getElementById('wallet-address-container');
        const display = document.getElementById('wallet-address-display');
        const placeholder = document.getElementById('wallet-placeholder');
        if (container && display && placeholder) {
            if (address) {
                display.textContent = address.slice(0, 6) + '...' + address.slice(-4);
                container.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                container.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }
    }

    window.copyToClipboard = function () {
        const address = window.walletManager?.userAddress;
        if (address) {
            navigator.clipboard.writeText(address).then(() => {
                // Optionally show a copied message
                // You can add a toast or temporary message here
            }).catch(err => {
                console.error('Failed to copy address:', err);
            });
        }
    }

    // Call updateWalletHeader after wallet connect/disconnect
    // Example: updateWalletHeader(window.walletManager?.userAddress);
    // You may want to call this in walletConnect.js after successful connect/disconnect

    console.log('✅ Bondr application initialized');
});
