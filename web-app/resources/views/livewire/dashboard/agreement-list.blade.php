<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    {{-- @extends('components.layouts.dashboard') --}}

    @section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Protected Deals</h1>
                    <p class="text-gray-600 text-lg">
                        Manage your smart contract agreements and track milestone progress
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="create_agreement_modal.showModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create New Deal
                    </button>
                    <button class="border-2 border-gray-300 text-gray-700 hover:border-blue-600 hover:text-blue-600 px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Total Deals</h3>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $totalCount ?? 0 }}</div>
                <div class="text-gray-600 text-sm">All agreements</div>
            </div>
    
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Active</h3>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $activeCount ?? 0 }}</div>
                <div class="text-gray-600 text-sm">In progress</div>
            </div>
    
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Completed</h3>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $completedCount ?? 0 }}</div>
                <div class="text-gray-600 text-sm">Successfully delivered</div>
            </div>
    
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Disputed</h3>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $disputedCount ?? 0 }}</div>
                <div class="text-gray-600 text-sm">Under review</div>
            </div>
        </div>
    
        <!-- Search and Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search deals by title or client..." 
                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                           id="searchInput" />
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-3">
                    <button class="filter-btn px-4 py-2 rounded-xl font-medium transition-all duration-200 bg-blue-600 text-white shadow-lg" data-filter="all">
                        All Deals
                        <span class="ml-2 bg-white/20 px-2 py-1 rounded-lg text-sm">{{ $totalCount ?? 8 }}</span>
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl font-medium transition-all duration-200 border-2 border-gray-300 text-gray-700 hover:border-green-500 hover:text-green-600" data-filter="active">
                        Active
                        <span class="ml-2 bg-gray-100 px-2 py-1 rounded-lg text-sm">{{ $activeCount ?? 3 }}</span>
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl font-medium transition-all duration-200 border-2 border-gray-300 text-gray-700 hover:border-purple-500 hover:text-purple-600" data-filter="completed">
                        Completed
                        <span class="ml-2 bg-gray-100 px-2 py-1 rounded-lg text-sm">{{ $completedCount ?? 4 }}</span>
                    </button>
                    <button class="filter-btn px-4 py-2 rounded-xl font-medium transition-all duration-200 border-2 border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-600" data-filter="disputed">
                        Disputed
                        <span class="ml-2 bg-gray-100 px-2 py-1 rounded-lg text-sm">{{ $disputedCount ?? 1 }}</span>
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Agreements Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6" id="agreementsGrid">
            <!-- Sample Agreement Cards -->
            <div class="agreement-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105" data-status="active" data-title="Website Redesign" data-client="TechCorp Inc">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-lg">Website Redesign</h3>
                                <p class="text-sm text-gray-600">TechCorp Inc</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Protected Value</span>
                            <span class="font-semibold text-gray-900">$5,000</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Progress</span>
                            <span class="text-sm font-medium text-gray-900">75%</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 75%"></div>
                        </div>
    
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Due: Dec 15, 2024</span>
                            <span>2 milestones left</span>
                        </div>
                    </div>
    
                    <div class="flex gap-3">
                        <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </button>
                        <button class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Manage
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="agreement-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105" data-status="completed" data-title="Logo Design" data-client="StartupXYZ">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M15 7l3-3m0 0l-3-3m3 3H9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-lg">Logo Design</h3>
                                <p class="text-sm text-gray-600">StartupXYZ</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            Completed
                        </span>
                    </div>
    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Protected Value</span>
                            <span class="font-semibold text-gray-900">$1,200</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Progress</span>
                            <span class="text-sm font-medium text-gray-900">100%</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                        </div>
    
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Completed: Nov 28, 2024</span>
                            <span class="text-green-600">Payment released</span>
                        </div>
                    </div>
    
                    <div class="flex gap-3">
                        <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </button>
                        <button class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            View Receipt
                        </button>
                    </div>
                </div>
            </div>
    
            <div class="agreement-card bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:scale-105" data-status="disputed" data-title="Mobile App Development" data-client="InnovateLab">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 text-lg">Mobile App Development</h3>
                                <p class="text-sm text-gray-600">InnovateLab</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Disputed
                        </span>
                    </div>
    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Protected Value</span>
                            <span class="font-semibold text-gray-900">$8,500</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Progress</span>
                            <span class="text-sm font-medium text-gray-900">60%</span>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-red-500 to-orange-600 h-2 rounded-full transition-all duration-300" style="width: 60%"></div>
                        </div>
    
                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>Due: Jan 10, 2025</span>
                            <span class="text-red-600">Under review</span>
                        </div>
                    </div>
    
                    <div class="flex gap-3">
                        <button class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View Details
                        </button>
                        <button class="flex-1 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 text-white px-4 py-2 rounded-xl font-medium transition-all duration-200">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Resolve
                        </button>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Empty State -->
        <div class="hidden text-center py-16" id="emptyState">
            <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No deals found</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">No agreements match your current search criteria. Try adjusting your filters or create a new deal to get started.</p>
            <button onclick="clearFilters()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                Clear Filters
            </button>
        </div>
    </div>
    
    {{-- @include(view: 'dashboard.partials.agreement-create-modal') --}}
    <x-agreement-create-modal />
    
    <script>
    // Enhanced filtering functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('searchInput');
        const agreementCards = document.querySelectorAll('.agreement-card');
        const emptyState = document.getElementById('emptyState');
        const agreementsGrid = document.getElementById('agreementsGrid');
        
        let currentFilter = 'all';
        let currentSearch = '';
        
        function filterAgreements() {
            let visibleCount = 0;
            
            agreementCards.forEach(card => {
                const status = card.dataset.status;
                const title = card.dataset.title.toLowerCase();
                const client = card.dataset.client.toLowerCase();
                
                const matchesFilter = currentFilter === 'all' || status === currentFilter;
                const matchesSearch = currentSearch === '' || 
                                    title.includes(currentSearch.toLowerCase()) || 
                                    client.includes(currentSearch.toLowerCase());
                
                if (matchesFilter && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            if (visibleCount === 0) {
                agreementsGrid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                agreementsGrid.style.display = 'grid';
                emptyState.style.display = 'none';
            }
        }
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active state from all buttons
                filterBtns.forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                    b.classList.add('border-2', 'border-gray-300', 'text-gray-700');
                });
                
                // Add active state to clicked button
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                btn.classList.remove('border-2', 'border-gray-300', 'text-gray-700');
                
                currentFilter = btn.dataset.filter;
                filterAgreements();
            });
        });
        
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value;
            filterAgreements();
        });
        
        window.clearFilters = function() {
            currentFilter = 'all';
            currentSearch = '';
            searchInput.value = '';
            
            // Reset filter buttons
            filterBtns.forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                b.classList.add('border-2', 'border-gray-300', 'text-gray-700');
            });
            filterBtns[0].classList.add('bg-blue-600', 'text-white', 'shadow-lg');
            filterBtns[0].classList.remove('border-2', 'border-gray-300', 'text-gray-700');
            
            filterAgreements();
        };
    });
    </script>
    @endsection
</div>
