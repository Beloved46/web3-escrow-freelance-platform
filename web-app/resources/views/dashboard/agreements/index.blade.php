<x-layouts.dashboard>

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Agreements</h1>
            <p class="text-base-content/70 mt-1">
                Manage your smart contracts and milestones
            </p>
        </div>
        <button class="btn btn-primary" onclick="create_agreement_modal.showModal()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Create New Agreement
        </button>
    </div>

    <!-- Search and Filter Section -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-base-content/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" placeholder="Search agreements..." 
                           class="input input-bordered pl-10 w-full" 
                           id="searchInput" />
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-primary filter-btn" data-filter="all">
                        All
                        <div class="badge badge-neutral">{{ $totalCount ?? 8 }}</div>
                    </button>
                    <button class="btn btn-sm btn-outline filter-btn" data-filter="active">
                        Active
                        <div class="badge badge-primary">{{ $activeCount ?? 3 }}</div>
                    </button>
                    <button class="btn btn-sm btn-outline filter-btn" data-filter="completed">
                        Completed
                        <div class="badge badge-success">{{ $completedCount ?? 4 }}</div>
                    </button>
                    <button class="btn btn-sm btn-outline filter-btn" data-filter="disputed">
                        Disputed
                        <div class="badge badge-error">{{ $disputedCount ?? 1 }}</div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Agreements Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="agreementsGrid">
        @include('agreements.partials.agreement-cards')
    </div>

    <!-- Empty State -->
    <div class="hidden text-center py-12" id="emptyState">
        <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-base-content/60 mb-2">No agreements found</h3>
        <p class="text-base-content/50 mb-4">No agreements match your current search criteria.</p>
        <button class="btn btn-primary" onclick="clearFilters()">Clear Filters</button>
    </div>
</div>

@include('agreements.partials.create-modal')

<script>
// Simple filtering functionality
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
            filterBtns.forEach(b => b.classList.remove('btn-primary'));
            filterBtns.forEach(b => b.classList.add('btn-outline'));
            btn.classList.add('btn-primary');
            btn.classList.remove('btn-outline');
            
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
        filterBtns.forEach(b => b.classList.remove('btn-primary'));
        filterBtns.forEach(b => b.classList.add('btn-outline'));
        filterBtns[0].classList.add('btn-primary');
        filterBtns[0].classList.remove('btn-outline');
        filterAgreements();
    };
});
</script>
</x-layouts.dashboard>
