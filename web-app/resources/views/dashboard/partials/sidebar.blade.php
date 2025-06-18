<aside class="bg-base-200 w-72 min-h-full border-r border-base-300">
    <!-- Logo Section -->
    <div class="p-6 border-b border-base-300">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-content" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-base-content">Bondr</h1>
                <p class="text-sm text-base-content/60">Smart Agreements</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4">
        <ul class="menu menu-lg">
            <li class="menu-title">
                <span>Main</span>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                {{-- {{ route('agreements.index') }}" --}}
                <a href="{{ route('agreements.index') }}" class="flex items-center justify-between {{ request()->routeIs('agreements.*') ? 'active' : '' }}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z"/>
                        </svg>
                        Agreements
                    </div>
                    <div class="badge badge-primary badge-sm">{{ $activeAgreements ?? 0 }}</div>
                </a>
            </li>
            <li>
                {{-- {{ route('milestones.index') }} --}}
                <a href="" class="flex items-center {{ request()->routeIs('milestones.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    Milestones
                </a>
            </li>
            
            <li class="menu-title mt-4">
                <span>Account</span>
            </li>
            <li>
                <a href="#" class="flex items-center {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    Profile
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    Settings
                </a>
            </li>
        </ul>
    </nav>
</aside>
