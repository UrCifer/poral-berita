<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kategori - Portal Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <header class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <i class="fas fa-newspaper text-2xl md:text-3xl mr-3"></i>
                    <h1 class="text-xl md:text-2xl font-bold">Portal<span class="text-yellow-300">Berita</span></h1>
                </a>
            </div>
            
            <div class="flex items-center">
                <button id="mobile-menu-toggle" class="md:hidden text-white text-2xl mr-4">
                    <i class="fas fa-bars"></i>
                </button>

                <nav class="hidden md:flex space-x-6 mr-6">
                    <a href="{{ route('home') }}" class="nav-link hover:text-yellow-300">Beranda</a>
                    <a href="{{ route('posts.daftar') }}" class="nav-link hover:text-yellow-300">Berita</a>
                    <a href="{{ route('categories.daftar') }}" class="nav-link hover:text-yellow-300 font-bold border-b-2 border-yellow-300">Kategori</a>
                    <a href="{{ route('about') }}" class="nav-link hover:text-yellow-300">Tentang</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="nav-link hover:text-yellow-300">Dashboard</a>
                    @endauth
                </nav>

                <div class="hidden md:flex space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="bg-white text-purple-700 px-4 py-2 rounded-full">Login</a>
                        <a href="{{ route('register') }}" class="bg-yellow-300 text-purple-800 px-4 py-2 rounded-full">Daftar</a>
                    @else
                        <div class="flex items-center space-x-3">
                            <span class="bg-purple-800 text-white px-4 py-2 rounded-full font-semibold">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full transition duration-300">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="fixed inset-0 bg-purple-900 z-50 hidden transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-white">Menu</h2>
                <button id="close-mobile-menu" class="text-white text-3xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="space-y-6">
                <a href="{{ route('home') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Beranda</a>
                <a href="{{ route('posts.daftar') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Berita Terbaru</a>
                <a href="{{ route('categories.daftar') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Kategori</a>
                <a href="{{ route('about') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Tentang</a>
            </nav>

            <div class="mt-8 space-y-4">
                @guest
                    <a href="{{ route('login') }}" class="w-full block bg-white text-purple-700 py-3 rounded-full font-semibold text-center">Login</a>
                    <a href="{{ route('register') }}" class="w-full block bg-yellow-400 text-purple-900 py-3 rounded-full font-semibold text-center">Daftar</a>
                @else
                    <span class="block text-white text-center text-lg font-semibold">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white py-3 rounded-full font-semibold">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    <main class="flex-grow">
        <!-- Page Header -->
        <section class="py-10 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Kategori Berita</h1>
                <p class="text-xl">Jelajahi berita berdasarkan kategori yang anda minati</p>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @php
                    $colors = [
                        ['bg-blue-100 text-blue-600', 'bg-blue-600'],
                        ['bg-green-100 text-green-600', 'bg-green-600'],
                        ['bg-purple-100 text-purple-600', 'bg-purple-600'],
                        ['bg-pink-100 text-pink-600', 'bg-pink-600'],
                        ['bg-yellow-100 text-yellow-600', 'bg-yellow-600'],
                        ['bg-indigo-100 text-indigo-600', 'bg-indigo-600'],
                        ['bg-red-100 text-red-600', 'bg-red-600'],
                        ['bg-orange-100 text-orange-600', 'bg-orange-600'],
                    ];
                    
                    $icons = [
                        'Politik' => 'fas fa-landmark',
                        'Teknologi' => 'fas fa-laptop-code',
                        'Olahraga' => 'fas fa-futbol',
                        'Hiburan' => 'fas fa-theater-masks',
                        'Pendidikan' => 'fas fa-graduation-cap',
                        'Bisnis' => 'fas fa-chart-line',
                        'Kesehatan' => 'fas fa-heartbeat',
                        'Gaya Hidup' => 'fas fa-coffee',
                        'Sains' => 'fas fa-flask',
                        'Otomotif' => 'fas fa-car',
                        'Travel' => 'fas fa-plane',
                        'Kuliner' => 'fas fa-utensils'
                    ];
                @endphp
                
                @foreach($categories as $index => $category)
                    @php
                        $colorIndex = $index % count($colors);
                        $cardColors = $colors[$colorIndex];
                        $icon = $icons[$category->name] ?? 'fas fa-newspaper';
                    @endphp
                    
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex justify-center mb-6">
                                <div class="{{ $cardColors[0] }} rounded-full w-20 h-20 flex items-center justify-center">
                                    <i class="{{ $icon }} text-3xl"></i>
                                </div>
                            </div>
                            
                            <h3 class="text-xl font-bold text-center mb-3">{{ $category->name }}</h3>
                            
                            <p class="text-gray-500 text-center mb-5">
                                {{ $category->posts_count }} {{ $category->posts_count == 1 ? 'Artikel' : 'Artikel' }}
                            </p>
                            
                            <div class="text-center">
                                <a href="{{ route('posts.daftar', ['category' => $category->id]) }}" 
                                   class="inline-block {{ $cardColors[1] }} text-white py-2 px-6 rounded-full hover:opacity-90 transition-opacity">
                                    Lihat Berita
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2 lg:col-span-1">
                    <h4 class="text-xl font-bold mb-4">Portal Berita</h4>
                    <p class="text-sm md:text-base">Sumber informasi terpercaya untuk berita terkini di Indonesia</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        @foreach($categories->take(3) as $category)
                            <li><a href="{{ route('posts.daftar', ['category' => $category->id]) }}" class="text-sm md:text-base hover:text-yellow-300">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <p class="text-sm md:text-base">Email: info@portalberita.com</p>
                    <p class="text-sm md:text-base">Telp: +62 812 3456 7890</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-xl md:text-2xl hover:text-yellow-300"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-xl md:text-2xl hover:text-yellow-300"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-xl md:text-2xl hover:text-yellow-300"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 border-t border-gray-700 pt-4">
                <p class="text-sm md:text-base">&copy; 2025 Portal Berita. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-purple-600 text-white w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-purple-700">
        <i class="fas fa-arrow-up text-sm md:text-base"></i>
    </button>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>