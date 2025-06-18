<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bondr - Smart Agreements Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="drawer lg:drawer-open min-h-screen">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        
        <!-- Main Content -->
        <div class="drawer-content flex flex-col bg-base-100">
            <!-- Topbar -->
            <div class="navbar bg-base-200 border-b border-base-300">
                <div class="flex-none lg:hidden">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2">
                    <span class="text-lg font-semibold">Dashboard</span>
                </div>
                <div class="flex-none">

                   {{-- <div class="px-2"> --}}
                    {{-- <a href="#" class="btn btn-primary px-2">
                        Connect Wallet
                    </a> --}}
                   {{-- </div> --}}

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Profile" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">Settings</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
        
        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
            @include('dashboard.partials.sidebar')
        </div>
    </div>
</body>
</html>
