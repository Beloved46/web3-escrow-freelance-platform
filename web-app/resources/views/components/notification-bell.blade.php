<div>
    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19H6.5A2.5 2.5 0 014 16.5v-9A2.5 2.5 0 016.5 5h9A2.5 2.5 0 0118 7.5v4.5"/>
            </svg>
            @if(($notificationCount ?? 3) > 0)
                <div class="badge badge-error badge-sm absolute -top-2 -right-2">{{ $notificationCount ?? 3 }}</div>
            @endif
        </div>
        
        <div tabindex="0" class="dropdown-content z-[1] card card-compact w-80 p-2 shadow bg-base-100 border border-base-200">
            <div class="card-body">
                <h3 class="font-bold">Notifications</h3>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @php
                    $notifications = $notifications ?? [
                        ['title' => 'New milestone approved', 'time' => '5 min ago', 'type' => 'success'],
                        ['title' => 'Payment received', 'time' => '1 hour ago', 'type' => 'info'],
                        ['title' => 'Document requires review', 'time' => '2 hours ago', 'type' => 'warning']
                    ];
                    @endphp
                    
                    @foreach($notifications as $notification)
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-base-200">
                        <div class="w-2 h-2 rounded-full 
                            @if($notification['type'] === 'success') bg-success
                            @elseif($notification['type'] === 'warning') bg-warning
                            @else bg-info
                            @endif
                        "></div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ $notification['title'] }}</p>
                            <p class="text-xs text-base-content/60">{{ $notification['time'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-actions">
                    <button class="btn btn-primary btn-block btn-sm">View All</button>
                </div>
            </div>
        </div>
    </div>
</div>