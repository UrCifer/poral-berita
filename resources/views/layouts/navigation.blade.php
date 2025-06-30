<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <span class="ml-2 text-lg font-bold text-gray-800">Portal Berita</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-10 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-md font-semibold transition-all duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
              
                
                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-1.5 border border-gray-200 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <img class="h-6 w-6 rounded-full object-cover mr-2 bg-blue-500 p-0.5" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=6366F1" alt="{{ Auth::user()->name }}">
                                    <span class="max-w-[90px] truncate text-sm">{{ Auth::user()->name }}</span>
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100 bg-gray-50">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 mt-1 truncate">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center">
                                <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="flex items-center">
                                    <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-md mr-2 transition-all duration-200">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md transition-all duration-200">
                        <i class="fas fa-user-plus mr-1"></i> Register
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-blue-50 text-blue-700 font-semibold rounded-md mx-2 flex items-center">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Dashboard
            </a>
            
            <a href="{{ route('menu_utama') }}" class="block px-4 py-2 bg-blue-600 text-black font-semibold rounded-md mx-2 mt-2 flex items-center">
                <i class="fas fa-home mr-2"></i>
                Menu Utama
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="flex items-center mb-3">
                        <img class="h-7 w-7 rounded-full object-cover mr-2 bg-blue-500 p-0.5" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=FFFFFF&background=6366F1" alt="{{ Auth::user()->name }}">
                        <div>
                            <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 space-y-1 border-t border-gray-200 pt-2">
                    <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center !text-gray-800">
                        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="flex items-center !text-gray-800">
                            <i class="fas fa-sign-out-alt mr-2 text-red-500"></i>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ route('login') }}" class="block text-gray-600 hover:text-blue-700 hover:bg-blue-50 px-3 py-2 rounded-md mb-1">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="block bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-md text-center">
                        <i class="fas fa-user-plus mr-1"></i> Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
