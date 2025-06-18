<div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200 hover:shadow-md transition-shadow">
    <div class="stat-figure text-blue-600">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"/>
        </svg>
    </div>
    <div class="stat-title text-base-content/70">Active Agreements</div>
    <div class="stat-value text-blue-600">{{ $activeAgreements ?? 3 }}</div>
    <div class="stat-desc text-success">
        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        Currently ongoing
    </div>
</div>

<div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200 hover:shadow-md transition-shadow">
    <div class="stat-figure text-green-600">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
        </svg>
    </div>
    <div class="stat-title text-base-content/70">Total Value</div>
    <div class="stat-value text-green-600">${{ number_format($totalValue ?? 12500, 0) }}</div>
    <div class="stat-desc text-base-content/60">Across all agreements</div>
</div>

<div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200 hover:shadow-md transition-shadow">
    <div class="stat-figure text-orange-600">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
    </div>
    <div class="stat-title text-base-content/70">Pending Milestones</div>
    <div class="stat-value text-orange-600">{{ $pendingMilestones ?? 5 }}</div>
    <div class="stat-desc text-warning">Awaiting action</div>
</div>

<div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200 hover:shadow-md transition-shadow">
    <div class="stat-figure text-emerald-600">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
    </div>
    <div class="stat-title text-base-content/70">Completed</div>
    <div class="stat-value text-emerald-600">{{ $completedAgreements ?? 12 }}</div>
    <div class="stat-desc text-success">Successfully finished</div>
</div>
