<div class="space-y-4">
    @php
    $milestones = [
        [
            'id' => 1,
            'name' => 'Initial Design Mockups',
            'description' => 'Create wireframes and initial design concepts',
            'status' => 'released',
            'value' => 1000,
            'due_date' => '2024-06-15',
            'submitted_date' => '2024-06-14'
        ],
        [
            'id' => 2,
            'name' => 'Frontend Development',
            'description' => 'Develop responsive frontend with modern UI components',
            'status' => 'funded',
            'value' => 2000,
            'due_date' => '2024-06-30',
            'submitted_date' => '2024-06-28'
        ],
        [
            'id' => 3,
            'name' => 'Backend Integration',
            'description' => 'Integrate with existing backend systems and APIs',
            'status' => 'pending',
            'value' => 1500,
            'due_date' => '2024-07-10'
        ],
        [
            'id' => 4,
            'name' => 'Testing & Deployment',
            'description' => 'Final testing, bug fixes, and production deployment',
            'status' => 'pending',
            'value' => 500,
            'due_date' => '2024-07-15'
        ]
    ];
    @endphp

    @foreach($milestones as $index => $milestone)
    <div class="card bg-base-50 border border-base-200">
        <div class="card-body">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="badge badge-neutral badge-sm">Milestone {{ $index + 1 }}</span>
                        <h3 class="font-semibold text-lg">{{ $milestone['name'] }}</h3>
                    </div>
                    <p class="text-base-content/70">{{ $milestone['description'] }}</p>
                </div>
                
                @if($milestone['status'] === 'released')
                    <div class="badge badge-success gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Released
                    </div>
                @elseif($milestone['status'] === 'funded')
                    <div class="badge badge-primary gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Funded
                    </div>
                @else
                    <div class="badge badge-warning gap-2">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Pending
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-6 text-sm text-base-content/60 mb-4">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    ${{ number_format($milestone['value']) }}
                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    Due: {{ \Carbon\Carbon::parse($milestone['due_date'])->format('M j, Y') }}
                </div>
                @if(isset($milestone['submitted_date']))
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Submitted: {{ \Carbon\Carbon::parse($milestone['submitted_date'])->format('M j, Y') }}
                    </div>
                @endif
            </div>

            @if($milestone['status'] === 'pending')
                <div class="alert alert-info mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    <span>Upload your work files to submit this milestone for review.</span>
                </div>
                
                <div class="border-2 border-dashed border-base-300 rounded-lg p-6 text-center hover:border-primary/50 hover:bg-primary/5 transition-colors cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    <p class="text-base-content/60 mb-2">Drop files here or click to browse</p>
                    <p class="text-sm text-base-content/40">Supports: PDF, DOC, ZIP, Images (max 10MB)</p>
                    <input type="file" class="hidden" multiple />
                </div>
            @endif

            @if($milestone['status'] === 'funded')
                <div class="flex gap-2 pt-2">
                    <button class="btn btn-success btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Approve
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Request Changes
                    </button>
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
