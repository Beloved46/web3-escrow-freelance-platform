'use strict';
/**
 * Agreement Form Handler
 * Handles USDC to ETH conversion and form interactions
 */

class AgreementFormHandler {
    constructor() {
        this.usdcConverter = window.usdcConverter;
        this.init();
    }

    async init() {
        // Initialize price display
        await this.updatePriceDisplay();

        // Set up event listeners
        this.setupEventListeners();

        // Update price every 5 minutes
        setInterval(() => this.updatePriceDisplay(), 5 * 60 * 1000);
    }

    setupEventListeners() {
        // USDC input change handler
        const usdcInput = document.getElementById('usdc_value_input');
        if (usdcInput) {
            usdcInput.addEventListener('input', (e) => this.handleUSDCInput(e.target.value));
        }

        // Modal open handler
        const modal = document.getElementById('create_agreement_modal');
        if (modal) {
            modal.addEventListener('show', () => this.updatePriceDisplay());
        }
    }

    async updatePriceDisplay() {
        try {
            const priceDisplay = document.getElementById('eth-price-display');
            if (priceDisplay) {
                const priceText = await this.usdcConverter.getPriceDisplay();
                priceDisplay.textContent = priceText;
            }
        } catch (error) {
            console.error('Failed to update price display:', error);
        }
    }

    async handleUSDCInput(usdcValue) {
        const ethEquivalent = document.getElementById('eth-equivalent');
        const ethHidden = document.getElementById('eth_value_hidden');

        if (!usdcValue || parseFloat(usdcValue) <= 0) {
            if (ethEquivalent) ethEquivalent.textContent = '≈ 0.0000 ETH';
            if (ethHidden) ethHidden.value = '';
            return;
        }

        try {
            const ethAmount = await this.usdcConverter.usdcToEth(parseFloat(usdcValue));

            if (ethEquivalent) {
                ethEquivalent.textContent = `≈ ${ethAmount.toFixed(4)} ETH`;
            }

            if (ethHidden) {
                ethHidden.value = ethAmount.toFixed(6);
            }
        } catch (error) {
            console.error('Failed to convert USDC to ETH:', error);
            if (ethEquivalent) {
                ethEquivalent.textContent = '≈ Error converting';
            }
        }
    }

    // Validate form before submission
    validateForm() {
        const usdcValue = document.getElementById('usdc_value_input')?.value;
        const ethValue = document.getElementById('eth_value_hidden')?.value;
        const creatorAddress = document.getElementById('creator_address_input')?.value;
        const title = document.querySelector('input[name="title"]')?.value;
        const description = document.querySelector('textarea[name="description"]')?.value;
        const dueDate = document.querySelector('input[name="due_date"]')?.value;

        const errors = [];

        if (!creatorAddress || !ethers.isAddress(creatorAddress)) {
            errors.push('Valid creator wallet address is required');
        }

        if (!title || title.trim().length < 3) {
            errors.push('Title must be at least 3 characters');
        }

        if (!description || description.trim().length < 10) {
            errors.push('Description must be at least 10 characters');
        }

        if (!usdcValue || parseFloat(usdcValue) <= 0) {
            errors.push('Valid USDC amount is required');
        }

        if (!ethValue || parseFloat(ethValue) <= 0) {
            errors.push('ETH conversion failed - please try again');
        }

        if (!dueDate) {
            errors.push('Due date is required');
        }

        return {
            isValid: errors.length === 0,
            errors
        };
    }

    // Show validation errors
    showValidationErrors(errors) {
        const feedback = document.getElementById('agreement-create-feedback');
        if (feedback) {
            feedback.textContent = errors.join('. ');
            feedback.className = 'text-red-600 bg-red-100 border border-red-200 rounded-lg px-4 py-3';
            feedback.classList.remove('hidden');
        }
    }

    // Clear validation errors
    clearValidationErrors() {
        const feedback = document.getElementById('agreement-create-feedback');
        if (feedback) {
            feedback.classList.add('hidden');
            feedback.textContent = '';
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.agreementFormHandler = new AgreementFormHandler();
});

// Export for module usage
export default AgreementFormHandler; 