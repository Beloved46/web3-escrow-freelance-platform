<header class="bg-white/95 backdrop-blur-sm border-b border-gray-100 sticky top-0 z-50" x-data="{ isMenuOpen: false }">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <a href="/">
                    <img 
                        src="{{ asset('images/bondr-logo.png') }}" 
                        alt="Bondr Logo" 
                        class="h-10 w-10"
                    >
                    <span class="text-2xl font-bold text-gray-900">Bondr</span>
                </a>
            </div>
            
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#how-it-works" class="text-gray-600 hover:text-primary transition-colors">
                    How It Works
                </a>
                <a href="#pricing" class="text-gray-600 hover:text-primary transition-colors">
                    Pricing
                </a>
                <a href="#features" class="text-gray-600 hover:text-primary transition-colors">
                    Features
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md transition-colors">
                            Login
                        </a>
                        <a href="#" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md transition-colors">
                            Start Your First Deal
                        </a>
                    @endauth
                @endif
            </nav>

            <button 
                class="md:hidden"
                @click="isMenuOpen = !isMenuOpen"
            >
                <svg x-show="!isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div x-show="isMenuOpen" x-transition class="md:hidden mt-4 pb-4 border-t pt-4">
            <nav class="flex flex-col space-y-4">
                <a href="#how-it-works" class="text-gray-600 hover:text-primary">
                    How It Works
                </a>
                <a href="#pricing" class="text-gray-600 hover:text-primary">
                    Pricing
                </a>
                <a href="#features" class="text-gray-600 hover:text-primary">
                    Features
                </a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="border border-gray-300 hover:bg-gray-50 px-4 py-2 rounded-md transition-colors">
                            Login
                        </a>
                        <a href="#" class="bg-primary hover:bg-primary-dark text-white px-6 py-2 rounded-md transition-colors">
                            Start Your First Deal
                        </a>
                    @endauth
                @endif
            </nav>
        </div>
    </div>
</header>