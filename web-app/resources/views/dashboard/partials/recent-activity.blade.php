<div class="space-y-4">
    @php
    $activities = $recentActivity ?? [
        [
            'id' => 1,
            'title' => 'Website Redesign Project',
            'client' => 'TechCorp Inc.',
            'action' => 'Milestone 2 approved',
            'time' => '2 hours ago',
            'status' => 'approved',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ],
        [
            'id' => 2,
            'title' => 'Mobile App Development',
            'client' => 'StartupXYZ',
            'action' => 'Work submitted for review',
            'time' => '1 day ago',
            'status' => 'pending',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ],
        [
            'id' => 3,
            'title' => 'Logo Design Package',
            'client' => 'Creative Agency',
            'action' => 'Payment released',
            'time' => '3 days ago',
            'status' => 'completed',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ]
    ];
    @endphp

    @forelse($activities as $activity)
    <div class="flex items-center justify-between p-4 bg-base-50 rounded-lg border border-base-200 hover:bg-base-100 transition-colors">
        <div class="flex items-center space-x-4">
            <div class="avatar">
                <div class="w-12 h-12 rounded-full">
                    <img src="{{ $activity['avatar'] }}" alt="Client avatar" />
                </div>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-base-content">{{ $activity['title'] }}</h4>
                <p class="text-sm text-base-content/60">Client: {{ $activity['client'] }}</p>
                <p class="text-sm font-medium text-base-content/80 mt-1">{{ $activity['action'] }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            @if($activity['status'] === 'completed')
                <div class="badge badge-success gap-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ ucfirst($activity['status']) }}
                </div>
            @elseif($activity['status'] === 'approved')
                <div class="badge badge-primary gap-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ ucfirst($activity['status']) }}
                </div>
            @else
                <div class="badge badge-warning gap-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    {{ ucfirst($activity['status']) }}
                </div>
            @endif
            <span class="text-xs text-base-content/50 whitespace-nowrap">{{ $activity['time'] }}</span>
        </div>
    </div>
    @empty
    <div class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-lg font-medium text-base-content/60 mb-2">No recent activity</h3>
        <p class="text-base-content/50">Your recent agreement activities will appear here.</p>
    </div>
    @endforelse
</div>
