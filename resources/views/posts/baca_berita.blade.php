<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $post->title }} - Portal Berita</title>
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
                    <a href="{{ route('posts.daftar') }}" class="nav-link hover:text-yellow-300 font-bold border-b-2 border-yellow-300">Berita</a>
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
        <!-- Breadcrumb -->
        <div class="bg-white shadow">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('home') }}" class="text-purple-600 hover:text-purple-800">Beranda</a>
                    <span class="mx-2 text-gray-500">/</span>
                    <a href="{{ route('posts.daftar') }}" class="text-purple-600 hover:text-purple-800">Berita</a>
                    <span class="mx-2 text-gray-500">/</span>
                    <a href="{{ route('posts.daftar', ['category' => $post->category_id]) }}" class="text-purple-600 hover:text-purple-800">{{ $post->category->name }}</a>
                    <span class="mx-2 text-gray-500">/</span>
                    <span class="text-gray-600">{{ \Illuminate\Support\Str::limit($post->title, 30) }}</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <article class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($post->image)
                            <div class="flex justify-center py-4">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-full max-h-[500px] object-contain rounded-lg shadow-lg">
                            </div>
                        @else
                            <div class="flex justify-center py-4">
                                <img src="https://infopublik.id/assets/upload/headline//IP_Menhan_Terima_Telp_Pres_Korse.jpg" alt="Default" class="max-w-full max-h-[500px] object-contain rounded-lg shadow-lg">
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-4">
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                                <span class="mx-3">|</span>
                                <span><i class="far fa-calendar-alt mr-1"></i> {{ $post->created_at->format('d F Y') }}</span>
                                <span class="mx-3">|</span>
                                <span><i class="far fa-user mr-1"></i> {{ $post->user->name }}</span>
                            </div>
                            
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">{{ $post->title }}</h1>
                            
                            <div class="prose max-w-none text-gray-700 leading-relaxed">
                                {!! $post->content !!}
                            </div>
                            
                            <!-- Share Buttons -->
                            <div class="mt-10 pt-6 border-t border-gray-200">
                                <h4 class="text-lg font-semibold mb-3">Bagikan Berita Ini:</h4>
                                <div class="flex space-x-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="bg-blue-600 text-white px-3 py-2 rounded-lg flex items-center">
                                        <i class="fab fa-facebook-f mr-2"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="bg-blue-400 text-white px-3 py-2 rounded-lg flex items-center">
                                        <i class="fab fa-twitter mr-2"></i> Twitter
                                    </a>
                                    <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" class="bg-green-500 text-white px-3 py-2 rounded-lg flex items-center">
                                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                    
                    <!-- Comment Section -->
                    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-6 text-gray-800">Komentar ({{ $post->comments->count() }})</h3>
                        
                        @if($post->comments->count() > 0)
                            <div class="space-y-6 mb-8">
                                @foreach($post->comments as $comment)
                                    <div class="flex space-x-4 border-b border-gray-100 pb-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                <span class="text-purple-700 font-bold">{{ substr($comment->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-gray-800">{{ $comment->user->name }}</h4>
                                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-1 text-gray-600">{{ $comment->content }}</p>
                                            
                                            @if(Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->role == 'admin'))
                                                <div class="mt-2 flex justify-end">
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 mb-8">Belum ada komentar pada berita ini.</p>
                        @endif
                        
                        <!-- Comment Form -->
                        @auth
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-semibold mb-4">Tinggalkan Komentar</h4>
                                
                                @if(session('success'))
                                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                
                                @if(session('error'))
                                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                
                                <form action="{{ route('comments.store', $post) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <textarea name="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" placeholder="Tulis komentar Anda..." required></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors">
                                            Kirim Komentar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-lg text-center">
                                <p class="mb-2">Silahkan login untuk menambahkan komentar</p>
                                <a href="{{ route('login') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors">Login</a>
                            </div>
                        @endauth
                    </div>
                    
                    <!-- Back Button -->
                    <div class="mt-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:w-1/3">
                    <!-- Related News -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Berita Terkait</h3>
                        <div class="space-y-4">
                            @forelse($relatedPosts as $relatedPost)
                                <div class="flex space-x-4">
                                    <div class="w-1/3">
                                        @if($relatedPost->image)
                                            <img src="{{ asset('storage/' . $relatedPost->image) }}" alt="{{ $relatedPost->title }}" class="w-full h-20 object-cover rounded shadow-md">
                                        @else
                                            <img src="https://infopublik.id/assets/upload/headline//IP_Menhan_Terima_Telp_Pres_Korse.jpg" alt="Default" class="w-full h-20 object-cover rounded shadow-md">
                                        @endif
                                    </div>
                                    <div class="w-2/3">
                                        <h4 class="font-medium text-gray-800 leading-tight">
                                            <a href="{{ route('posts.baca', $relatedPost) }}" class="hover:text-purple-600">
                                                {{ \Illuminate\Support\Str::limit($relatedPost->title, 60) }}
                                            </a>
                                        </h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ $relatedPost->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500">Belum ada berita terkait.</p>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold mb-4 text-gray-800">Kategori</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach (\App\Models\Category::all() as $category)
                                <a href="{{ route('posts.daftar', ['category' => $category->id]) }}" 
                                   class="bg-gray-100 hover:bg-purple-100 hover:text-purple-700 text-gray-700 px-3 py-1 rounded-full text-sm">
                                   {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        @foreach(\App\Models\Category::take(3)->get() as $category)
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