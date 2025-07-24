<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <!-- Create New Agreement -->
    <a href="{{ route('agreements.create') }}" class="group block bg-white dark:bg-base-100 border border-base-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition flex items-center space-x-4">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 group-hover:bg-indigo-100">
            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        </span>
        <div>
            <div class="font-semibold text-base-content">Create New Agreement</div>
            <div class="text-sm text-base-content/60">Start a new deal with a freelancer or team</div>
        </div>
    </a>
    <!-- Fund Milestone -->
    <a href="{{ route('dashboard') }}#milestones" class="group block bg-white dark:bg-base-100 border border-base-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition flex items-center space-x-4">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 group-hover:bg-blue-100">
            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 7v9m8-4a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
        </span>
        <div>
            <div class="font-semibold text-base-content">Fund Milestone</div>
            <div class="text-sm text-base-content/60">Lock payment for a project milestone</div>
        </div>
    </a>
    <!-- Invite Team -->
    <a href="{{ route('dashboard') }}#invite" class="group block bg-white dark:bg-base-100 border border-base-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition flex items-center space-x-4">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-50 group-hover:bg-indigo-100">
            <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2a4 4 0 10-8 0 4 4 0 008 0zm6-2a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
        </span>
        <div>
            <div class="font-semibold text-base-content">Invite Team</div>
            <div class="text-sm text-base-content/60">Add collaborators or clients to your workspace</div>
        </div>
    </a>
    <!-- View Trust Score -->
    <a href="{{ route('dashboard') }}#trust" class="group block bg-white dark:bg-base-100 border border-base-200 rounded-xl shadow-sm p-5 hover:shadow-lg transition flex items-center space-x-4">
        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 group-hover:bg-blue-100">
            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V4m0 7v9m8-4a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
        </span>
        <div>
            <div class="font-semibold text-base-content">View Trust Score</div>
            <div class="text-sm text-base-content/60">See your on-chain reputation and history</div>
        </div>
    </a>
</div>