@props(['agreement'])

<div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-all duration-200 hover:border-primary/20">
    <div class="card-body">
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center space-x-3">
                <div class="avatar">
                    <div class="w-10 h-10 rounded-lg bg-primary/10">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="font-semibold text-base-content">{{ $agreement['title'] ?? 'Agreement Title' }}</h3>
                    <p class="text-sm text-base-content/60">{{ $agreement['client'] ?? 'Client Name' }}</p>
                </div>
            </div>
            
            @if(isset($agreement['status']))
                @if($agreement['status'] === 'active')
                    <div class="badge badge-success badge-sm">Active</div>
                @elseif($agreement['status'] === 'pending')
                    <div class="badge badge-warning badge-sm">Pending</div>
                @else
                    <div class="badge badge-neutral badge-sm">{{ ucfirst($agreement['status']) }}</div>
                @endif
            @endif
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-base-content/60">Value</span>
                <span class="font-semibold text-base-content">${{ number_format($agreement['value'] ?? 0) }}</span>
            </div>
            
            <div class="flex justify-between items-center">
                <span class="text-sm text-base-content/60">Progress</span>
                <span class="text-sm font-medium">{{ $agreement['progress'] ?? 0 }}%</span>
            </div>
            
            <div class="w-full bg-base-200 rounded-full h-2">
                <div class="bg-primary h-2 rounded-full transition-all duration-300" 
                     style="width: {{ $agreement['progress'] ?? 0 }}%"></div>
            </div>
        </div>

        <div class="card-actions justify-between mt-4">
            <div class="text-xs text-base-content/50">
                Due: {{ $agreement['due_date'] ?? 'No due date' }}
            </div>
            <div class="flex gap-2">
                <button class="btn btn-ghost btn-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View
                </button>
                <button class="btn btn-primary btn-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Manage
                </button>
            </div>
        </div>
    </div>
</div>
