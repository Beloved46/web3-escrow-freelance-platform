<div>
    @section('content')
    <div class="space-y-8">
        <!-- Enhanced Header with Back Button -->
        <div class="bg-gradient-to-r from-white to-gray-50 rounded-3xl shadow-sm border border-gray-100 p-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('agreements.index') }}" class="group w-14 h-14 bg-white hover:bg-gray-50 rounded-2xl flex items-center justify-center transition-all duration-300 shadow-sm hover:shadow-md border border-gray-200">
                    <svg class="w-7 h-7 text-gray-600 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 id="agreement-title" class="text-4xl font-bold text-gray-900 mb-3 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent"></h1>
                    <p class="text-gray-600 text-xl font-medium">
                        Protected deal details and milestone tracking
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <span id="agreement-status" class="inline-flex items-center px-6 py-3 rounded-2xl text-sm font-semibold shadow-sm"></span>
                    <button id="manage-deal-btn" class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-700 text-white px-8 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="inline w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Manage Deal
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Enhanced Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl shadow-sm border border-blue-200 p-8 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Protected Value</h3>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div id="protected-value" class="text-4xl font-bold text-gray-900 mb-3"></div>
                <div class="text-gray-600 text-base font-medium">In escrow protection</div>
            </div>
    
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-3xl shadow-sm border border-green-200 p-8 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Progress</h3>
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div id="progress-value" class="text-4xl font-bold text-gray-900 mb-3"></div>
                <div id="progress-label" class="text-gray-600 text-base font-medium"></div>
            </div>
    
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-3xl shadow-sm border border-purple-200 p-8 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Due Date</h3>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div id="due-date" class="text-4xl font-bold text-gray-900 mb-3"></div>
                <div id="due-year" class="text-gray-600 text-base font-medium"></div>
            </div>
    
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl shadow-sm border border-orange-200 p-8 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Time Left</h3>
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div id="time-left" class="text-4xl font-bold text-gray-900 mb-3"></div>
                <div class="text-gray-600 text-base font-medium">Remaining</div>
            </div>
        </div>
    
        <!-- Enhanced Deal Overview -->
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Deal Overview</h2>
                <p id="deal-overview" class="text-gray-600 text-xl leading-relaxed"></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="flex items-center gap-5 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Client</p>
                        <p id="client-name" class="text-xl font-bold text-gray-900"></p>
                    </div>
                </div>
                
                <div class="flex items-center gap-5 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Creator</p>
                        <p id="creator-name" class="text-xl font-bold text-gray-900"></p>
                    </div>
                </div>
    
                <div class="flex items-center gap-5 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Contract Type</p>
                        <p id="contract-type" class="text-xl font-bold text-gray-900"></p>
                    </div>
                </div>
    
                <div class="flex items-center gap-5 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-semibold uppercase tracking-wide">Created</p>
                        <p id="created-date" class="text-xl font-bold text-gray-900"></p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Enhanced Milestones Section -->
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl shadow-sm border border-gray-100 p-10">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4 bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Milestones</h2>
                    <p class="text-gray-600 text-xl font-medium">Track progress and manage deliverables</p>
                </div>
                <div class="flex gap-4">
                    <button id="add-milestone-btn" class="group border-2 border-gray-300 text-gray-700 hover:border-blue-600 hover:text-blue-600 px-6 py-3 rounded-2xl font-semibold transition-all duration-300 hover:shadow-md transform hover:-translate-y-0.5">
                        <svg class="inline w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Milestone
                    </button>
                    <button id="raise-dispute-btn" class="group bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-3 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="inline w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Raise Dispute
                    </button>
                </div>
            </div>
            <div id="milestones-list" class="space-y-6"></div>
        </div>
    
        <!-- Enhanced Smart Contract Status -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl shadow-xl p-10 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-indigo-800/20"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-4">Smart Contract Protection</h2>
                        <p class="text-blue-100 text-xl font-medium">Your deal is secured by blockchain technology</p>
                    </div>
                    <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-lg">Escrow Active</span>
                        </div>
                        <p id="escrow-status" class="text-blue-100 text-base font-medium"></p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-lg">Dispute Resolution</span>
                        </div>
                        <p class="text-blue-100 text-base font-medium">Arbitration available if needed</p>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-lg">Auto Release</span>
                        </div>
                        <p class="text-blue-100 text-base font-medium">Automatic payment on approval</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>
