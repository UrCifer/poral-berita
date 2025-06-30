<!DOCTYPE html>  
<html lang="id">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">  
    <title>Portal Berita Kekinian</title>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Notification popup styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 30px;
            background-color: #10B981;
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s, transform 0.3s;
        }
        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        .notification i {
            margin-right: 10px;
        }
        .notification-close {
            margin-left: 15px;
            cursor: pointer;
        }
    </style>
</head>  
<body class="bg-gray-100 flex flex-col min-h-screen">  

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

    <header class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white shadow-lg">  
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">  
            <div class="flex items-center">  
                <i class="fas fa-newspaper text-2xl md:text-3xl mr-3"></i>  
                <h1 class="text-xl md:text-2xl font-bold">Portal<span class="text-yellow-300">Berita</span></h1>  
            </div>  
            
            <div class="flex items-center">  
                <button id="mobile-menu-toggle" class="md:hidden text-white text-2xl mr-4">  
                    <i class="fas fa-bars"></i>  
                </button>  

                <nav class="hidden md:flex space-x-6 mr-6">  
                    <a href="{{ route('home') }}" class="nav-link hover:text-yellow-300">Beranda</a>  
                    <a href="{{ route('posts.daftar') }}" class="nav-link hover:text-yellow-300">Berita</a>  
                    <a href="{{ route('categories.daftar') }}" class="nav-link hover:text-yellow-300">Kategori</a>
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

    <!-- Hero Section with Image Slider -->  
    <section class="hero-section py-12 md:py-20 text-center text-white relative overflow-hidden">
        <!-- Image Slider Container -->
        <div class="hero-slider absolute inset-0 z-0">
            <div class="slide-item active" style="background-image: url('https://images.unsplash.com/photo-1495020689067-958852a7765e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1950&q=80')"></div>
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1974&q=80')"></div>
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1503694978374-8a2fa686963a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1950&q=80')"></div>
            <div class="slide-item" style="background-image: url('https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')"></div>
        </div>
        
        <!-- Overlay for better text visibility -->
        <div class="absolute inset-0 bg-purple-900 bg-opacity-70 z-10"></div>
        
        <!-- Slider navigation arrows -->
        <button id="prev-slide" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-black bg-opacity-50 text-white w-10 h-10 rounded-full flex items-center justify-center">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-black bg-opacity-50 text-white w-10 h-10 rounded-full flex items-center justify-center">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Content -->  
        <div class="container mx-auto px-4 relative z-20">  
            <h2 class="text-2xl md:text-4xl font-bold mb-4">Berita Terkini Yang Terpercaya</h2>  
            <p class="text-base md:text-xl mb-6 max-w-2xl mx-auto">Dapatkan informasi terbaru dan terpercaya dari berbagai kategori</p>  
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-4">  
                <a href="{{ route('posts.daftar') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 md:px-8 rounded-full">  
                    Berita Terbaru  
                </a>  
                <a href="{{ route('categories.daftar') }}" class="bg-white text-purple-700 hover:bg-yellow-300 font-bold py-3 px-6 md:px-8 rounded-full">  
                    Kategori  
                </a>  
            </div>  
        </div>  
    </section>  


    <!-- Kategori Populer -->  
    <section class="container mx-auto px-4 py-12">  
        <div class="text-center mb-10">  
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Kategori Populer</h2>  
            <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi berita terkini dari berbagai kategori yang paling diminati</p>  
        </div>  

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">  
            @foreach($categories->take(6) as $index => $category)
                @php
                    // Define different color combinations for each category card
                    $colorClasses = [
                        ['bg-blue-100 text-blue-600', 'text-blue-600 hover:text-blue-800'],
                        ['bg-green-100 text-green-600', 'text-green-600 hover:text-green-800'],
                        ['bg-purple-100 text-purple-600', 'text-purple-600 hover:text-purple-800'],
                        ['bg-pink-100 text-pink-600', 'text-pink-600 hover:text-pink-800'],
                        ['bg-yellow-100 text-yellow-600', 'text-yellow-600 hover:text-yellow-800'],
                        ['bg-indigo-100 text-indigo-600', 'text-indigo-600 hover:text-indigo-800']
                    ];
                    
                    // Get color class for current category (cycle through colors)
                    $colorIndex = $index % count($colorClasses);
                    $bgTextColor = $colorClasses[$colorIndex][0];
                    $linkColor = $colorClasses[$colorIndex][1];
                    
                    // Select appropriate icon for category
                    $icons = [
                        'Politik' => 'fas fa-landmark',
                        'Teknologi' => 'fas fa-laptop-code',
                        'Olahraga' => 'fas fa-futbol',
                        'Hiburan' => 'fas fa-theater-masks',
                        'Pendidikan' => 'fas fa-graduation-cap',
                        'Bisnis' => 'fas fa-chart-line'
                    ];
                    
                    $icon = $icons[$category->name] ?? 'fas fa-newspaper';
                @endphp
                
                <div class="category-card bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">  
                    <div class="p-6 text-center">  
                        <div class="{{ $bgTextColor }} rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">  
                            <i class="{{ $icon }} text-3xl"></i>  
                        </div>  
                        <h3 class="font-bold text-lg mb-2">{{ $category->name }}</h3>  
                        <p class="text-gray-500 text-sm">{{ $category->posts_count }} {{ $category->posts_count == 1 ? 'Berita' : 'Berita' }}</p>  
                        <a href="{{ route('posts.daftar', ['category' => $category->id]) }}" class="mt-4 inline-block {{ $linkColor }} font-medium">  
                            Lihat Berita <i class="fas fa-arrow-right ml-2"></i>  
                        </a>  
                    </div>  
                </div>
            @endforeach
        </div>  
    </section>  

    <!-- Berita Utama -->  
<section class="container mx-auto px-4 py-8">  
    <h3 class="text-xl md:text-2xl font-bold mb-6">Berita Utama</h3>  
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">  
        @forelse($approvedPosts as $post)
        <!-- Kartu Berita Responsif -->  
        <div class="news-card bg-white rounded-lg overflow-hidden shadow-md">  
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
            @else
                <img src="https://infopublik.id/assets/upload/headline//IP_Menhan_Terima_Telp_Pres_Korse.jpg" alt="Default" class="w-full h-48 object-cover">
            @endif
            <div class="p-6">  
                <span class="text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $post->category->name }}</span>  
                <h4 class="text-base md:text-lg font-bold mt-2">{{ $post->title }}</h4>  
                <p class="text-sm md:text-base text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}</p>  
                <div class="flex justify-between items-center mt-4">  
                    <a href="{{ route('posts.baca', $post->id) }}" class="text-purple-600 hover:underline text-sm md:text-base">Baca Selengkapnya</a>  
                    <span class="text-gray-500 text-xs md:text-sm">{{ $post->created_at->format('d F Y') }}</span>  
                </div>  
            </div>  
        </div>
        @empty
        <div class="col-span-3 text-center py-8">
            <p class="text-gray-500">Belum ada berita yang tersedia.</p>
        </div>
        @endforelse
    </div>  

    <!-- Tombol View More -->  
    <div class="text-center mt-8">  
        <a href="{{ route('posts.daftar') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-full inline-block transition duration-300 ease-in-out transform hover:scale-105">  
            Lihat Berita Lainnya  
            <i class="fas fa-chevron-right ml-2"></i>  
        </a>  
    </div>  
</section>  

<!-- Berita Internasional -->
<section class="container mx-auto px-4 py-12 bg-gray-50">
    <div class="text-center mb-10">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Berita Internasional</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">Informasi terbaru dari berbagai belahan dunia</p>
    </div>

    <div id="international-news-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="col-span-full flex justify-center">
            <div class="loader flex items-center justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-purple-700"></div>
            </div>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="{{ route('international.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full inline-block transition duration-300 ease-in-out transform hover:scale-105">
            Lihat Lebih Banyak Berita Internasional
            <i class="fas fa-globe ml-2"></i>
        </a>
    </div>
</section>

    <!-- Footer -->  
    <footer class="bg-gray-900 text-white py-12 mt-auto">  
        <div class="container mx-auto px-4">  
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">  
                <div class="md:col-span-2 lg:col-span-1">  
                    <h4 class="text-xl font-bold mb-4">Portal Berita</h4>  
                    <p class="text-sm md:text-base">Sumber informasi terpercaya untuk berita terkini di Indonesia</p>  
                </div>  
                

                <div>  
                    <h4 class="font-bold mb-4">Kategori</h4>  
                    <ul class="space-y-2">  
                        <li><a href="{{ route('posts.daftar', ['category' => 1]) }}" class="text-sm md:text-base hover:text-yellow-300">Politik</a></li>  
                        <li><a href="{{ route('posts.daftar', ['category' => 2]) }}" class="text-sm md:text-base hover:text-yellow-300">Teknologi</a></li>  
                        <li><a href="{{ route('posts.daftar', ['category' => 3]) }}" class="text-sm md:text-base hover:text-yellow-300">Olahraga</a></li>  
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

    <!-- Add script reference here -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Notification Popup Container -->
    @if(session('success'))
    <div id="notification" class="notification">
        <div>
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <span class="notification-close">&times;</span>
    </div>
    @endif
    
    <script>
        // Notification popup functionality
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            if (notification) {
                // Show notification
                setTimeout(function() {
                    notification.classList.add('show');
                }, 300);
                
                // Hide notification after 5 seconds
                setTimeout(function() {
                    notification.classList.remove('show');
                    setTimeout(function() {
                        notification.remove();
                    }, 300);
                }, 5000);
                
                // Close notification when X is clicked
                const closeBtn = notification.querySelector('.notification-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', function() {
                        notification.classList.remove('show');
                        setTimeout(function() {
                            notification.remove();
                        }, 300);
                    });
                }
            }
        });
    </script>
</body>  
</html>