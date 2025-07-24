@extends('components.layouts.dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 text-lg">
                    Your trust layer is active. Here's what's happening with your protected deals today.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="create_agreement_modal.showModal()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create New Deal
                </button>
                <a href="{{ route('agreements.index') }}" class="border-2 border-gray-300 text-gray-700 hover:border-blue-600 hover:text-blue-600 px-6 py-3 rounded-xl font-semibold transition-all duration-200 text-center">
                    View All Deals
                </a>
            </div>
        </div>
    </div>

    <!-- Trust Score & Key Metrics -->
    <div id="dashboard-stats" class="grid grid-cols-1 lg:grid-cols-4 gap-6"></div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Activity</h2>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View all</a>
                </div>
                <div id="recentActivity" class="space-y-4"></div>
            </div>
        </div>
        <!-- Quick Actions & Stats -->
        <div class="space-y-6">
            {{-- @include('dashboard.partials.quick-actions') --}}
            {{-- @include('dashboard.partials.protection-status') --}}
        </div>
    </div>
    <!-- Agreement List -->
    <div id="agreementsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8"></div>
</div>

@include('dashboard.partials.agreement-create-modal')
@endsection
