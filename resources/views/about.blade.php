<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tentang Kami - Portal Berita</title>
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
                    <a href="{{ route('categories.daftar') }}" class="nav-link hover:text-yellow-300">Kategori</a>
                    <a href="{{ route('about') }}" class="nav-link hover:text-yellow-300 font-bold border-b-2 border-yellow-300">Tentang</a>
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
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Tentang Kami</h1>
                <p class="text-xl">Mengenal lebih dekat dengan Portal Berita</p>
            </div>
        </section>

        <!-- About Content -->
        <section class="container mx-auto px-4 py-12">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" 
                             alt="Newsroom" class="w-full h-full object-cover">
                    </div>
                    <div class="md:w-1/2 p-6 md:p-12">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Sumber Informasi Terpercaya</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Portal Berita adalah platform berita digital yang menyajikan informasi terkini, akurat, dan terpercaya dari berbagai kategori. Didirikan pada tahun 2023, kami berkomitmen untuk menjadi sumber informasi utama bagi masyarakat Indonesia.
                        </p>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Kami memiliki tim jurnalis profesional dan berpengalaman yang bekerja keras untuk menghadirkan berita berkualitas dengan standar jurnalisme tertinggi. Setiap berita yang dipublikasikan melalui portal ini telah melalui proses verifikasi dan penyuntingan yang ketat.
                        </p>
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                <i class="fas fa-check text-purple-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Terpercaya</h3>
                                <p class="text-gray-600">Informasi yang akurat dan terverifikasi</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                <i class="fas fa-bolt text-purple-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Cepat</h3>
                                <p class="text-gray-600">Update berita terbaru dalam waktu singkat</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mr-4">
                                <i class="fas fa-balance-scale text-purple-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">Berimbang</h3>
                                <p class="text-gray-600">Penyajian berita yang objektif dan netral</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision Mission -->
            <div class="mt-12 grid md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-indigo-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Visi Kami</h3>
                    <p class="text-gray-600">
                        Menjadi portal berita digital terdepan dan terpercaya di Indonesia, yang mengedepankan kebenaran, objektivitas, dan integritas dalam penyajian informasi kepada masyarakat.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Misi Kami</h3>
                    <ul class="text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Menyajikan berita dan informasi yang akurat, terkini, dan berimbang</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Menjunjung tinggi etika jurnalisme dan kode etik pers</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Menghadirkan konten yang edukatif dan menginspirasi bagi masyarakat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Berperan aktif dalam mencerdaskan kehidupan bangsa melalui informasi yang berkualitas</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Team Section -->
            <div class="mt-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 text-center">Tim Redaksi Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Editor" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-1">Andi Permana</h3>
                            <p class="text-purple-600 text-sm mb-3">Pemimpin Redaksi</p>
                            <p class="text-gray-600 text-sm">
                                Berpengalaman lebih dari 15 tahun di industri jurnalisme dan media digital.
                            </p>
                            <div class="mt-4 flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-700"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-800"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Editor" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-1">Dewi Anggraeni</h3>
                            <p class="text-purple-600 text-sm mb-3">Redaktur Politik</p>
                            <p class="text-gray-600 text-sm">
                                Spesialis liputan politik dengan pengalaman meliput berbagai peristiwa politik nasional.
                            </p>
                            <div class="mt-4 flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-700"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-800"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Editor" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-1">Budi Santoso</h3>
                            <p class="text-purple-600 text-sm mb-3">Redaktur Teknologi</p>
                            <p class="text-gray-600 text-sm">
                                Memiliki keahlian dalam bidang teknologi dan inovasi digital terkini.
                            </p>
                            <div class="mt-4 flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-700"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-800"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg overflow-hidden shadow-md">
                        <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Editor" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-1">Maya Indira</h3>
                            <p class="text-purple-600 text-sm mb-3">Redaktur Lifestyle</p>
                            <p class="text-gray-600 text-sm">
                                Jurnalis dengan pengalaman di bidang gaya hidup, hiburan dan tren terkini.
                            </p>
                            <div class="mt-4 flex space-x-3">
                                <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-700"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="text-gray-400 hover:text-blue-800"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mt-16 bg-white p-8 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Hubungi Kami</h2>
                
                <div class="space-y-6">
                    <p class="text-gray-600 mb-6">
                        Kami senang mendengar dari Anda. Jika Anda memiliki pertanyaan, saran, atau ingin berkolaborasi dengan kami, silakan hubungi kami melalui kontak di bawah ini.
                    </p>
                    
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <i class="fas fa-map-marker-alt text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Alamat</h4>
                                <p class="text-gray-600">Jl.Raya Bambu Apus No 6, Jakarta Timur, 13890</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <i class="fas fa-phone-alt text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Telepon</h4>
                                <p class="text-gray-600">+62 95 3249 53916</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <i class="fas fa-envelope text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Email</h4>
                                <p class="text-gray-600">info@portalberita.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-100 rounded-full p-3 mr-4">
                                <i class="fas fa-clock text-purple-600"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">Jam Kerja</h4>
                                <p class="text-gray-600">Senin - Jumat: 09:00 - 17:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
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

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>