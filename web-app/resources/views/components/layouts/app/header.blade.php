<header class="bg-white/95 backdrop-blur-sm border-b border-gray-100 sticky top-0 z-50 shadow-sm" x-data="{ isMenuOpen: false }">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <span class="text-white font-bold text-lg">B</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">Bondr</span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">
                    How It Works
                </a>
                <a href="#features" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">
                    Features
                </a>
                <a href="#pricing" class="text-gray-600 hover:text-blue-600 transition-colors font-medium">
                    Pricing
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Dashboard
                        </a>
                    @else
                        {{-- <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            Login
                        </a> --}}
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Start Hiring Safely
                        </a>
                    @endauth
                @endif
            </nav>

            <!-- Mobile Menu Button -->
            <button 
                class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                @click="isMenuOpen = !isMenuOpen"
            >
                <svg x-show="!isMenuOpen" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="isMenuOpen" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="isMenuOpen" x-transition class="md:hidden mt-4 pb-4 border-t border-gray-200 pt-4">
            <nav class="flex flex-col space-y-4">
                <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 font-medium py-2 transition-colors">
                    How It Works
                </a>
                <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium py-2 transition-colors">
                    Features
                </a>
                <a href="#pricing" class="text-gray-600 hover:text-blue-600 font-medium py-2 transition-colors">
                    Pricing
                </a>
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg text-center">
                            Dashboard
                        </a>
                    @else
                        <div class="flex flex-col space-y-3 pt-2">
                            {{-- <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium py-2 transition-colors text-center">
                                Login
                            </a> --}}
                            <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg text-center">
                                Start Hiring Safely
                            </a>
                        </div>
                    @endauth
                @endif
            </nav>
        </div>
    </div>
</header>