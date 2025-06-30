<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $article['title'] }} - Portal Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-newspaper text-2xl md:text-3xl mr-3"></i>
                <h1 class="text-xl md:text-2xl font-bold">Portal<span class="text-yellow-300">Berita</span></h1>
            </div>
            
            <div class="flex items-center">
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

    <!-- Breadcrumb -->
    <div class="bg-gray-200 py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-indigo-700 hover:text-indigo-900">Beranda</a>
                <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                <a href="{{ route('home') }}#international-news-container" class="text-indigo-700 hover:text-indigo-900">Berita Internasional</a>
                <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                <span class="text-gray-600 truncate max-w-xs">{{ $article['title'] }}</span>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row">
            <!-- Main Article -->
            <div class="lg:w-2/3 lg:pr-8">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <!-- Article Header -->
                    <div class="relative">
                        @php
                            // Cek apakah URL gambar valid
                            $imageUrl = $article['urlToImage'] ?? null;
                            if (!$imageUrl || $imageUrl == 'null' || $imageUrl == 'undefined' || strpos($imageUrl, 'unavailable') !== false) {
                                // Gunakan gambar fallback berdasarkan sumber berita
                                $sourceName = strtolower($article['source']['name'] ?? '');
                                if (strpos($sourceName, 'politic') !== false || strpos($sourceName, 'world') !== false) {
                                    $imageUrl = 'https://images.unsplash.com/photo-1612594181377-64ac85880ceb?q=80&w=800';
                                } elseif (strpos($sourceName, 'tech') !== false) {
                                    $imageUrl = 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?q=80&w=800';
                                } elseif (strpos($sourceName, 'health') !== false) {
                                    $imageUrl = 'https://images.unsplash.com/photo-1631815584016-2ef8873d5170?q=80&w=800';
                                } elseif (strpos($sourceName, 'space') !== false || strpos($sourceName, 'science') !== false) {
                                    $imageUrl = 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?q=80&w=800';
                                } elseif (strpos($sourceName, 'art') !== false || strpos($sourceName, 'culture') !== false) {
                                    $imageUrl = 'https://images.unsplash.com/photo-1580656449548-a223a88dce5c?q=80&w=800';
                                } else {
                                    $imageUrl = 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $article['title'] }}" class="w-full h-80 object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                            <span class="inline-block bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold mb-4">{{ $article['source']['name'] }}</span>
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white">{{ $article['title'] }}</h1>
                        </div>
                    </div>
                    
                    <!-- Article Meta -->
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ $article['author'] ?? 'Staff Reporter' }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($article['publishedAt'])->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $article['title'] }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://wa.me/?text={{ $article['title'] }}%20{{ url()->current() }}" target="_blank" class="text-green-500 hover:text-green-700">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ $article['title'] }}&body=Baca artikel ini: {{ url()->current() }}" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Article Body -->
                    <div class="px-6 py-6">
                        <div class="text-lg mb-6 italic text-gray-700">{{ $article['description'] }}</div>
                        
                        <div class="prose max-w-none">
                            {!! nl2br(e($article['content'])) !!}
                        </div>
                        
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-gray-500 text-sm">Sumber: {{ $article['source']['name'] }}</p>
                            @if($article['url'] != '#')
                            <p class="mt-2">
                                <a href="{{ $article['url'] }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center">
                                    Lihat artikel asli 
                                    <i class="fas fa-external-link-alt ml-2"></i>
                                </a>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:w-1/3 mt-8 lg:mt-0">
                <!-- Related Articles -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-indigo-700 text-white">
                        <h3 class="font-bold text-lg">Berita Terkait</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($relatedArticles as $related)
                        <div class="p-4 hover:bg-gray-50">
                            <a href="{{ route('international.show', $related['id']) }}" class="block">
                                <div class="flex">
                                    <div class="w-20 h-20 bg-gray-200 rounded overflow-hidden">
                                        @php
                                            // Cek apakah URL gambar valid
                                            $imageUrl = $related['urlToImage'] ?? null;
                                            if (!$imageUrl || $imageUrl == 'null' || $imageUrl == 'undefined' || strpos($imageUrl, 'unavailable') !== false) {
                                                // Gunakan gambar fallback berdasarkan sumber berita
                                                $sourceName = strtolower($related['source']['name'] ?? '');
                                                if (strpos($sourceName, 'politic') !== false || strpos($sourceName, 'world') !== false) {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1612594181377-64ac85880ceb?q=80&w=800';
                                                } elseif (strpos($sourceName, 'tech') !== false) {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?q=80&w=800';
                                                } elseif (strpos($sourceName, 'health') !== false) {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1631815584016-2ef8873d5170?q=80&w=800';
                                                } elseif (strpos($sourceName, 'space') !== false || strpos($sourceName, 'science') !== false) {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?q=80&w=800';
                                                } elseif (strpos($sourceName, 'art') !== false || strpos($sourceName, 'culture') !== false) {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1580656449548-a223a88dce5c?q=80&w=800';
                                                } else {
                                                    $imageUrl = 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="{{ $related['title'] }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-sm font-semibold line-clamp-2">{{ $related['title'] }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($related['publishedAt'])->format('d M Y') }}</p>
                                        <span class="text-xs text-indigo-600 mt-1 block">{{ $related['source']['name'] }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Back to News -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden p-6 text-center">
                    <h3 class="font-bold text-lg mb-4">Jelajahi Berita Lainnya</h3>
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('home') }}" class="bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700">Kembali ke Beranda</a>
                        <a href="{{ route('posts.daftar') }}" class="bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700">Berita Nasional</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->  
    <footer class="bg-gray-900 text-white py-12 mt-12">  
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

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>