@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header with Back Button -->
    <div class="flex items-center gap-4">
        <a href="{{ route('agreements.index') }}" class="btn btn-ghost btn-circle">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold">{{ $agreement['title'] ?? 'Website Redesign Project' }}</h1>
            <p class="text-base-content/70 mt-1">
                Agreement details and milestone tracking
            </p>
        </div>
        <div class="badge badge-primary badge-lg">Active</div>
    </div>

    <!-- Agreement Overview -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-header p-6 border-b border-base-200">
            <h2 class="card-title text-xl">Agreement Overview</h2>
            <p class="text-base-content/70">Complete redesign of the corporate website including new branding, responsive design, and improved user experience.</p>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-base-content/50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm text-base-content/60">Client</p>
                        <p class="font-medium">TechCorp Inc.</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-base-content/50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm text-base-content/60">Creator</p>
                        <p class="font-medium">John Doe (You)</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-base-content/50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    <div>
                        <p class="text-sm text-base-content/60">Total Value</p>
                        <p class="font-medium">$5,000</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-base-content/50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm text-base-content/60">Due Date</p>
                        <p class="font-medium">July 15, 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Milestones -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-header p-6 border-b border-base-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="card-title text-xl">Milestones</h2>
                    <p class="text-base-content/70">Track progress and manage deliverables</p>
                </div>
                <button class="btn btn-outline btn-error">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Raise Dispute
                </button>
            </div>
        </div>
        <div class="card-body">
            @include('agreements.partials.milestones')
        </div>
    </div>
</div>
@endsection
