<div class="space-y-6">
    @php
    $activities = $recentActivity ?? [
        [
            'id' => 1,
            'title' => 'Website Redesign Project',
            'client' => 'TechCorp Inc.',
            'action' => 'Milestone 2 approved',
            'action_type' => 'approved',
            'actor' => 'Client',
            'time' => '2 hours ago',
            'status' => 'approved',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ],
        [
            'id' => 2,
            'title' => 'Mobile App Development',
            'client' => 'StartupXYZ',
            'action' => 'Work submitted for review',
            'action_type' => 'submitted',
            'actor' => 'You',
            'time' => '1 day ago',
            'status' => 'pending',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ],
        [
            'id' => 3,
            'title' => 'Logo Design Package',
            'client' => 'Creative Agency',
            'action' => 'Payment released',
            'action_type' => 'completed',
            'actor' => 'You',
            'time' => '3 days ago',
            'status' => 'completed',
            'avatar' => 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp'
        ]
    ];
    // Icon map for action types
    $iconMap = [
        'approved' => '<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        'submitted' => '<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3a1 1 0 00-1-1h-6a1 1 0 00-1 1v9m0 0l4 4 4-4"/></svg>',
        'completed' => '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        'dispute' => '<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'default' => '<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg>',
    ];
    @endphp

    @forelse($activities as $activity)
    <div class="flex items-start space-x-4 relative group">
        <!-- Timeline dot -->
        <div class="flex flex-col items-center">
            <div class="w-3 h-3 rounded-full bg-indigo-500 border-2 border-white shadow-lg mt-2"></div>
            @if(!$loop->last)
                <div class="flex-1 w-px bg-base-200 h-full"></div>
            @endif
        </div>
        <!-- Card -->
        <div class="flex-1 bg-white dark:bg-base-100 rounded-xl border border-base-200 shadow-sm p-4 hover:shadow-md transition">
            <div class="flex items-center space-x-3 mb-2">
                <span class="inline-block align-middle">{!! $iconMap[$activity['action_type']] ?? $iconMap['default'] !!}</span>
                <span class="font-semibold text-base-content">{{ $activity['action'] }}</span>
                @if($activity['status'] === 'completed')
                    <span class="badge badge-success ml-2">Completed</span>
                @elseif($activity['status'] === 'approved')
                    <span class="badge badge-primary ml-2">Approved</span>
                @elseif($activity['status'] === 'pending')
                    <span class="badge badge-warning ml-2">Pending</span>
                @elseif($activity['status'] === 'dispute')
                    <span class="badge badge-warning ml-2">Dispute</span>
                @else
                    <span class="badge badge-ghost ml-2">{{ ucfirst($activity['status']) }}</span>
                @endif
            </div>
            <div class="flex items-center space-x-2">
                <div class="avatar">
                    <div class="w-8 h-8 rounded-full">
                        <img src="{{ $activity['avatar'] }}" alt="{{ $activity['actor'] }} avatar" />
                    </div>
                </div>
                <div class="text-sm text-base-content/70">
                    <span class="font-medium">{{ $activity['actor'] }}</span>
                    <span class="mx-1">•</span>
                    <span>{{ $activity['title'] }}</span>
                    <span class="mx-1">•</span>
                    <span class="text-xs text-base-content/50">{{ $activity['time'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="flex flex-col items-center justify-center py-12 bg-base-50 rounded-xl border border-base-200 shadow-inner">
        <svg class="w-16 h-16 text-indigo-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <h3 class="text-lg font-semibold text-base-content/70 mb-2">No recent activity yet</h3>
        <p class="text-base-content/50">Your agreement and payment activity will show up here as you use Bondr.</p>
    </div>
    @endforelse
</div>
