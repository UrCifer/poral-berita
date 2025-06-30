<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Berita Internasional' }} - Portal Berita</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <!-- Preconnect to important domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://images.unsplash.com" crossorigin>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('css/styles.css') }}" as="style">
    <link rel="preload" href="{{ asset('js/script.js') }}" as="script">
    
    <!-- Meta description -->
    <meta name="description" content="Berita internasional terkini dari seluruh dunia. Dapatkan informasi teraktual mengenai politik, ekonomi, teknologi, dan isu-isu global.">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header -->
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
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full">Logout</button>
                        </form>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden bg-purple-800 fixed inset-0 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex justify-end p-4">
            <button id="mobile-menu-close" class="text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="p-4 space-y-4">
            <a href="{{ route('home') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Beranda</a>
            <a href="{{ route('posts.daftar') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Berita Terbaru</a>
            <a href="{{ route('categories.daftar') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Kategori</a>
            <a href="{{ route('about') }}" class="block text-white text-xl hover:bg-purple-700 p-3 rounded-lg">Tentang</a>

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

    <!-- Breadcrumb -->
    <div class="bg-gray-200 py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-indigo-700 hover:text-indigo-900">Beranda</a>
                <i class="fas fa-chevron-right text-gray-500 mx-2"></i>
                <span class="text-gray-600">Berita Internasional</span>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <div class="bg-indigo-800 text-white py-10">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-bold">Berita Internasional</h1>
            <p class="mt-2 text-indigo-200">Perkembangan terbaru dari berbagai penjuru dunia</p>
        </div>
    </div>

    <!-- News Content -->
    <div class="container mx-auto px-4 py-10">
        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($articles as $article)
                @php
                    // Format tanggal
                    $date = \Carbon\Carbon::parse($article['publishedAt']);
                    $day = $date->format('d');
                    $month = $date->locale('id')->format('M');
                    $articleId = $article['id'];
                    $publishDate = \Carbon\Carbon::parse($article['publishedAt'])->locale('id')->isoFormat('D MMMM YYYY');
                    
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
                            // Default fallback image
                            $imageUrl = 'https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800';
                        }
                    }
                @endphp
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 h-full flex flex-col">
                    <div class="relative">
                        <div class="absolute top-0 left-0 bg-indigo-600 text-white text-center py-1 px-3 m-2 rounded shadow">
                            <div class="text-center">
                                <span class="block text-lg font-bold leading-none">{{ $day }}</span>
                                <span class="block text-xs uppercase">{{ $month }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('international.show', $articleId) }}">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E" 
                                data-src="{{ $imageUrl }}" 
                                alt="{{ $article['title'] }}" 
                                class="w-full h-52 object-cover lazy-load"
                                loading="lazy">
                        </a>
                        
                        <!-- Badge sumber berita -->
                        <div class="absolute bottom-0 right-0 bg-indigo-700 text-white px-3 py-1 m-2 rounded-full text-xs font-semibold">
                            {{ $article['source']['name'] }}
                        </div>
                    </div>
                    <div class="p-6 flex-grow">
                        <div class="flex items-center mb-3">
                            @if(isset($article['author']) && $article['author'])
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    <span>{{ $article['author'] }}</span>
                                </div>
                            @endif
                            <span class="mx-2 text-gray-300">|</span>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-clock mr-2"></i>
                                <span>{{ $publishDate }}</span>
                            </div>
                        </div>
                        
                        <h2 class="text-xl font-bold mb-3 line-clamp-2">
                            <a href="{{ route('international.show', $articleId) }}" class="text-gray-800 hover:text-indigo-700">
                                {{ $article['title'] }}
                            </a>
                        </h2>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($article['description']), 120) }}</p>
                        
                        <!-- Keywords/Tags -->
                        <div class="mt-4 mb-4 flex flex-wrap gap-2">
                            @php
                                // Generate keywords berdasarkan judul
                                $keywords = [];
                                $title = $article['title'] ?? '';
                                $words = explode(' ', $title);
                                $filteredWords = array_filter($words, function($word) {
                                    return strlen($word) > 5 && !in_array(strtolower($word), ['karena', 'dengan', 'tetapi', 'namun', 'adalah', 'menjadi', 'tentang', 'tersebut', 'daripada', 'sementara']);
                                });
                                $keywords = array_slice($filteredWords, 0, 2);
                                
                                // Tambahkan kategori berdasarkan sumber
                                $sourceName = strtolower($article['source']['name'] ?? '');
                                if (strpos($sourceName, 'politic') !== false || strpos($sourceName, 'world') !== false) {
                                    $keywords[] = 'Politik';
                                } elseif (strpos($sourceName, 'tech') !== false) {
                                    $keywords[] = 'Teknologi';
                                } elseif (strpos($sourceName, 'health') !== false) {
                                    $keywords[] = 'Kesehatan';
                                } elseif (strpos($sourceName, 'space') !== false || strpos($sourceName, 'science') !== false) {
                                    $keywords[] = 'Sains';
                                } elseif (strpos($sourceName, 'art') !== false || strpos($sourceName, 'culture') !== false) {
                                    $keywords[] = 'Budaya';
                                }
                            @endphp
                            
                            @foreach($keywords as $keyword)
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $keyword }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-6 pt-0 mt-auto">
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <a href="{{ route('international.show', $articleId) }}" class="text-white bg-indigo-600 hover:bg-indigo-700 font-medium rounded-lg text-sm px-4 py-2 transition duration-300 flex items-center">
                                <span>Baca selengkapnya</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            
                            <!-- Social share buttons -->
                            <div class="flex space-x-2">
                                <a href="https://twitter.com/intent/tweet?url={{ route('international.show', $articleId) }}&text={{ $article['title'] }}" target="_blank" class="text-blue-400 hover:text-blue-600">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('international.show', $articleId) }}" target="_blank" class="text-blue-700 hover:text-blue-900">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://wa.me/?text={{ $article['title'] }}%20{{ route('international.show', $articleId) }}" target="_blank" class="text-green-500 hover:text-green-700">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <i class="fas fa-newspaper text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-500">Belum ada berita internasional tersedia</h3>
                    <p class="mt-2 text-gray-400">Silakan coba lagi nanti</p>
                    <a href="{{ route('home') }}" class="mt-6 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg">
                        Kembali ke Beranda
                    </a>
                </div>
            @endforelse
        </div>
        
        <!-- Subscribe Card -->
        <div class="mt-16 bg-gradient-to-r from-indigo-800 to-purple-800 rounded-xl shadow-xl overflow-hidden">
            <div class="p-8 md:p-12 flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 mb-8 md:mb-0">
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">Dapatkan Berita Internasional Terkini</h3>
                    <p class="text-indigo-200">Berlangganan newsletter kami untuk mendapatkan pemberitahuan tentang berita internasional terbaru langsung ke email Anda.</p>
                </div>
                <div class="md:w-1/3 flex items-center">
                    <form action="#" class="w-full">
                        <div class="flex">
                            <input type="email" placeholder="Email Anda" class="flex-grow px-4 py-3 rounded-l-lg focus:outline-none" required>
                            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-medium px-4 py-3 rounded-r-lg transition duration-300">
                                Langganan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}" defer></script>
    
    <!-- Lazy Loading Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let lazyImages = [].slice.call(document.querySelectorAll("img.lazy-load"));
            
            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove("lazy-load");
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });
                
                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            } else {
                // Fallback untuk browser yang tidak mendukung IntersectionObserver
                let active = false;
                
                const lazyLoad = function() {
                    if (active === false) {
                        active = true;
                        
                        setTimeout(function() {
                            lazyImages.forEach(function(lazyImage) {
                                if ((lazyImage.getBoundingClientRect().top <= window.innerHeight && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {
                                    lazyImage.src = lazyImage.dataset.src;
                                    lazyImage.classList.remove("lazy-load");
                                    
                                    lazyImages = lazyImages.filter(function(image) {
                                        return image !== lazyImage;
                                    });
                                    
                                    if (lazyImages.length === 0) {
                                        document.removeEventListener("scroll", lazyLoad);
                                        window.removeEventListener("resize", lazyLoad);
                                        window.removeEventListener("orientationChange", lazyLoad);
                                    }
                                }
                            });
                            
                            active = false;
                        }, 200);
                    }
                };
                
                document.addEventListener("scroll", lazyLoad);
                window.addEventListener("resize", lazyLoad);
                window.addEventListener("orientationChange", lazyLoad);
                lazyLoad();
            }
        });
    </script>
</body>
</html>