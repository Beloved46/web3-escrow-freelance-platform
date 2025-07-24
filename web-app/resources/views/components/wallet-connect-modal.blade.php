<div id="wallet-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white dark:bg-base-100 rounded-2xl shadow-2xl p-8 w-full max-w-md relative">
        <!-- Close button -->
        <button id="close-modal" class="absolute top-4 right-4 text-base-content/60 hover:text-base-content/90 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div class="flex flex-col items-center">
            <div class="mb-4">
                <svg class="w-14 h-14 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8m-4-4v8"/></svg>
            </div>
            <h2 class="text-2xl font-bold mb-2 text-base-content">Connect your wallet</h2>
            <p class="text-base-content/70 mb-6 text-center">Securely connect your wallet to manage agreements, payments, and your on-chain trust score.</p>
            <button id="metamask-btn" class="w-full flex items-center justify-center space-x-3 bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition mb-4">
                <img src="https://raw.githubusercontent.com/MetaMask/brand-resources/master/SVG/metamask-fox.svg" alt="MetaMask" class="w-7 h-7">
                <span>Connect with MetaMask</span>
            </button>
            <button id="walletconnect-btn" class="w-full flex items-center justify-center space-x-3 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition mb-4">
                <img src="https://walletconnect.com/_next/static/media/logo_mark.4c4876b6.svg" alt="WalletConnect" class="w-7 h-7">
                <span>Connect with WalletConnect</span>
            </button>
            <div id="wallet-connected" class="w-full text-center mt-4 hidden">
                <div class="mb-2 text-base-content/80">Connected as:</div>
                <div class="font-mono text-base-content text-lg mb-2 flex items-center justify-center">
                    <span id="wallet-address-display"></span>
                    <button onclick="copyToClipboard()" class="ml-2 text-indigo-500 hover:text-indigo-700 focus:outline-none" title="Copy address">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15V5a2 2 0 012-2h10a2 2 0 012 2v10"/></svg>
                    </button>
                    <span class="copied-text ml-2 text-green-500 text-xs hidden">Copied!</span>
                </div>
                <button id="disconnect-wallet" class="mt-2 px-4 py-2 rounded-lg bg-base-200 hover:bg-base-300 text-base-content/70 font-medium transition">Disconnect</button>
            </div>
            <div id="wallet-disconnected" class="w-full text-center mt-4">
                <span class="text-base-content/60 text-sm">Not connected</span>
            </div>
        </div>
    </div>
</div> 