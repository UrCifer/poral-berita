<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Berita Terkini - Portal Berita</title>
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

    <main class="flex-grow">
        <!-- Page Header -->
        <section class="py-10 bg-gradient-to-r from-purple-600 to-indigo-700 text-white">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Berita Terkini</h1>
                <p class="text-xl">Temukan informasi terbaru dari berbagai kategori</p>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="container mx-auto px-4 py-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex flex-wrap items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2 md:mb-0">Filter Berdasarkan Kategori:</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('posts.daftar') }}" class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                            Semua
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('posts.daftar', ['category' => $category->id]) }}" 
                               class="px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Articles Grid -->
        <section class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <img src="https://infopublik.id/assets/upload/headline//IP_Menhan_Terima_Telp_Pres_Korse.jpg" alt="Default" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm bg-blue-100 text-blue-700 px-2 py-1 rounded-full">{{ $post->category->name }}</span>
                                <span class="text-gray-500 text-sm">{{ $post->created_at->format('d F Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3 text-gray-800">{{ $post->title }}</h3>
                            <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}</p>
                            <a href="{{ route('posts.baca', $post) }}" class="text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-16">
                        <div class="bg-white rounded-lg shadow p-8">
                            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Berita</h3>
                            <p class="text-gray-500">Belum ada berita yang tersedia dalam kategori ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
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

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>