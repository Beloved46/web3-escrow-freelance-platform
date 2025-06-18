@php
$mockAgreements = $agreements ?? [
    [
        'id' => 1,
        'title' => 'Website Redesign Project',
        'client' => 'TechCorp Inc.',
        'creator' => 'You',
        'milestones' => 4,
        'completed_milestones' => 2,
        'status' => 'active',
        'value' => 5000,
        'due_date' => '2024-07-15',
        'progress' => 50
    ],
    [
        'id' => 2,
        'title' => 'Mobile App Development',
        'client' => 'StartupXYZ',
        'creator' => 'You',
        'milestones' => 6,
        'completed_milestones' => 1,
        'status' => 'active',
        'value' => 8000,
        'due_date' => '2024-08-30',
        'progress' => 17
    ],
    [
        'id' => 3,
        'title' => 'Logo Design Package',
        'client' => 'Creative Agency',
        'creator' => 'You',
        'milestones' => 3,
        'completed_milestones' => 3,
        'status' => 'completed',
        'value' => 1500,
        'due_date' => '2024-06-01',
        'progress' => 100
    ],
    [
        'id' => 4,
        'title' => 'E-commerce Platform',
        'client' => 'RetailCo',
        'creator' => 'You',
        'milestones' => 8,
        'completed_milestones' => 4,
        'status' => 'disputed',
        'value' => 12000,
        'due_date' => '2024-09-15',
        'progress' => 50
    ]
];
@endphp

@foreach($mockAgreements as $agreement)
<div class="agreement-card card bg-base-100 shadow-sm border border-base-200 hover:shadow-lg hover:border-primary/30 transition-all duration-200 cursor-pointer"
     data-status="{{ $agreement['status'] }}"
     data-title="{{ $agreement['title'] }}"
     data-client="{{ $agreement['client'] }}"
     onclick="window.location.href='{{ route('agreements.show', $agreement['id']) }}'">
     
    <div class="card-body">
        <!-- Header -->
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h3 class="card-title text-lg mb-2">{{ $agreement['title'] }}</h3>
                <div class="flex items-center gap-4 text-sm text-base-content/60">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        {{ $agreement['client'] }}
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                        ${{ number_format($agreement['value']) }}
                    </div>
                </div>
            </div>
            
            @if($agreement['status'] === 'active')
                <div class="badge badge-primary">Active</div>
            @elseif($agreement['status'] === 'completed')
                <div class="badge badge-success">Completed</div>
            @elseif($agreement['status'] === 'disputed')
                <div class="badge badge-error">Disputed</div>
            @else
                <div class="badge badge-neutral">{{ ucfirst($agreement['status']) }}</div>
            @endif
        </div>

        <!-- Progress Section -->
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-base-content/70">Progress</span>
                    <span class="font-medium">{{ $agreement['completed_milestones'] }}/{{ $agreement['milestones'] }} milestones</span>
                </div>
                <div class="w-full bg-base-200 rounded-full h-2">
                    <div class="bg-primary h-2 rounded-full transition-all duration-300" 
                         style="width: {{ $agreement['progress'] }}%"></div>
                </div>
            </div>
            
            <!-- Footer Info -->
            <div class="flex items-center justify-between text-sm text-base-content/60">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    Due: {{ \Carbon\Carbon::parse($agreement['due_date'])->format('M j, Y') }}
                </div>
                <span class="font-medium">{{ $agreement['progress'] }}% complete</span>
            </div>
        </div>
    </div>
</div>
@endforeach
