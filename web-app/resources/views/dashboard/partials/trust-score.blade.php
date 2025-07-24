<div class="bg-white dark:bg-base-100 border border-base-200 rounded-xl shadow-sm p-6 flex flex-col items-center text-center">
    <div class="flex items-center space-x-2 mb-2">
        <span class="text-lg font-semibold text-base-content">On-chain Trust Score</span>
        <span class="tooltip tooltip-bottom" data-tip="Your trust score is built from on-chain activity, successful agreements, and positive reviews.">
            <svg class="w-5 h-5 text-indigo-400 cursor-pointer" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-4m0-4h.01"/></svg>
        </span>
    </div>
    <div class="mb-4">
        <span id="trust-score-value" class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-blue-400 shadow-lg text-white text-4xl font-bold border-4 border-white dark:border-base-100">
            --
        </span>
    </div>
    <div class="text-base-content/70 mb-4">
        Your trust score reflects your reputation and reliability on Bondr. Higher scores unlock more features and faster deals.
    </div>
    <ul class="text-left space-y-2 mb-4 w-full max-w-xs mx-auto">
        <li class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span>3 successful agreements</span>
        </li>
        <li class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span>No disputes</span>
        </li>
        <li class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span>2 positive reviews</span>
        </li>
    </ul>
    <div class="w-full max-w-xs mx-auto">
        <div class="flex items-center justify-between mb-1">
            <span class="text-xs text-base-content/50">Next level</span>
            <span class="text-xs text-base-content/50" id="trust-score-label">--/100</span>
        </div>
        <div class="w-full bg-base-200 rounded-full h-2.5 mb-2">
            <div id="trust-score-bar" class="bg-gradient-to-r from-indigo-500 to-blue-400 h-2.5 rounded-full" style="width: 0%;"></div>
        </div>
        <div class="text-xs text-base-content/60">Tip: Complete more agreements and receive positive reviews to increase your score.</div>
    </div>
</div> 