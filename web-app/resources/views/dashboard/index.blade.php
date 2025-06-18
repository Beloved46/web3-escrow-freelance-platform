<x-layouts.dashboard>

    @section('content')
        <div class="space-y-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-base-content">Welcome back, {{ auth()->user()->name }}!</h1>
                    <p class="text-lg text-base-content/70 mt-2">
                        Here's what's happening with your smart agreements today.
                    </p>
                </div>
                <div class="flex gap-3">
                    <button class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        New Agreement
                    </button>
                    {{-- {{ route('agreements.index') }} --}}
                    <a href="{{ route('agreements.index') }}" class="btn btn-primary">
                        View All Agreements
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200">
                    <div class="stat-figure text-primary">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Total Agreements</div>
                    <div class="stat-value text-primary">{{ $totalAgreements ?? 0 }}</div>
                    <div class="stat-desc">{{ $newAgreementsThisMonth ?? 0 }} created this month</div>
                </div>

                <div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200">
                    <div class="stat-figure text-success">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="stat-title">Active</div>
                    <div class="stat-value text-success">{{ $activeAgreements ?? 0 }}</div>
                    <div class="stat-desc">{{ $completedThisWeek ?? 0 }} completed this week</div>
                </div>

                <div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200">
                    <div class="stat-figure text-warning">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="stat-title">Pending</div>
                    <div class="stat-value text-warning">{{ $pendingAgreements ?? 0 }}</div>
                    <div class="stat-desc">{{ $overdueAgreements ?? 0 }} overdue</div>
                </div>

                <div class="stat bg-base-100 rounded-xl shadow-sm border border-base-200">
                    <div class="stat-figure text-info">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
                    <div class="stat-title">Total Value</div>
                    <div class="stat-value text-info">${{ number_format($totalValue ?? 0) }}</div>
                    <div class="stat-desc">${{ number_format($valueThisMonth ?? 0) }} this month</div>
                </div>
            </div>

            <!-- Recent Activity & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="card bg-base-100 shadow-sm border border-base-200">
                        <div class="card-body">
                            <h2 class="card-title text-xl">Recent Activity</h2>
                            <div class="space-y-4 mt-4">
                                @forelse($recentActivity ?? [] as $activity)
                                <div class="flex items-start space-x-3 p-3 rounded-lg bg-base-50">
                                    <div class="flex-shrink-0 w-2 h-2 mt-2 bg-primary rounded-full"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-base-content/60 mt-1">{{ $activity['time'] }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-base-content/30 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-base-content/60">No recent activity</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    <div class="card bg-gradient-to-r from-primary to-primary-focus text-primary-content shadow-lg">
                        <div class="card-body">
                            <h3 class="card-title text-lg">Quick Actions</h3>
                            <div class="space-y-3 mt-4">
                                <button class="btn btn-ghost btn-block justify-start text-primary-content hover:bg-primary-content/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Create Agreement
                                </button>
                                <button class="btn btn-ghost btn-block justify-start text-primary-content hover:bg-primary-content/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Upload Document
                                </button>
                                <button class="btn btn-ghost btn-block justify-start text-primary-content hover:bg-primary-content/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    View Reports
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-layouts.dashboard>
