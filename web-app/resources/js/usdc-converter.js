'use strict';

/**
 * USDC to ETH Converter Utility
 * Provides real-time conversion between USDC and ETH for better UX
 */

class USDCConverter {
    constructor() {
        this.ethPrice = null;
        this.lastUpdate = null;
        this.updateInterval = 5 * 60 * 1000; // 5 minutes
    }

    /**
     * Get current ETH price in USD
     */
    async getETHPrice() {
        const now = Date.now();
        
        // Return cached price if recent
        if (this.ethPrice && this.lastUpdate && (now - this.lastUpdate) < this.updateInterval) {
            return this.ethPrice;
        }

        try {
            // Fetch from CoinGecko API
            const response = await fetch('https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=usd');
            const data = await response.json();
            
            this.ethPrice = data.ethereum.usd;
            this.lastUpdate = now;
            
            console.log('💰 ETH Price updated:', this.ethPrice);
            return this.ethPrice;
        } catch (error) {
            console.error('❌ Failed to fetch ETH price:', error);
            
            // Fallback to cached price or default
            if (this.ethPrice) {
                return this.ethPrice;
            }
            
            // Default fallback price (can be updated manually)
            return 3500; // $3500 per ETH
        }
    }

    /**
     * Convert USDC amount to ETH
     */
    async usdcToEth(usdcAmount) {
        const ethPrice = await this.getETHPrice();
        return usdcAmount / ethPrice;
    }

    /**
     * Convert ETH amount to USDC
     */
    async ethToUsdc(ethAmount) {
        const ethPrice = await this.getETHPrice();
        return ethAmount * ethPrice;
    }

    /**
     * Format USDC amount with proper formatting
     */
    formatUSDC(amount) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        }).format(amount);
    }

    /**
     * Format ETH amount
     */
    formatETH(amount) {
        return `${parseFloat(amount).toFixed(4)} ETH`;
    }

    /**
     * Get price display string
     */
    async getPriceDisplay() {
        const price = await this.getETHPrice();
        return `1 ETH = $${price.toLocaleString()}`;
    }
}

// Create global instance
window.usdcConverter = new USDCConverter();

// Export for module usage
export default USDCConverter; 