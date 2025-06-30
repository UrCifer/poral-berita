<style>
    /* Ensure delete buttons are always red with white text */
    .bg-gradient-to-r.from-red-500.to-red-600,
    .bg-gradient-to-r.from-red-600.to-red-700 {
        background-image: linear-gradient(to right, #ef4444, #dc2626) !important;
        color: white !important;
    }
    
    /* Force white text on red buttons */
    .bg-gradient-to-r.from-red-500.to-red-600 *,
    .bg-gradient-to-r.from-red-600.to-red-700 * {
        color: white !important;
    }
    
    /* Ensure save buttons are always indigo with white text */
    .bg-gradient-to-r.from-indigo-500.to-indigo-600,
    .bg-gradient-to-r.from-indigo-600.to-indigo-700 {
        background-image: linear-gradient(to right, #6366f1, #4f46e5) !important;
        color: white !important;
    }
    
    /* Force white text on indigo buttons */
    .bg-gradient-to-r.from-indigo-500.to-indigo-600 *,
    .bg-gradient-to-r.from-indigo-600.to-indigo-700 * {
        color: white !important;
    }

    /* Ensure blue buttons are always blue with white text */
    .bg-gradient-to-r.from-blue-600.to-indigo-600,
    .bg-gradient-to-r.from-blue-700.to-indigo-700,
    .bg-blue-600, 
    .bg-blue-700 {
        background-image: linear-gradient(to right, #2563eb, #4f46e5) !important;
        color: white !important;
    }
    
    /* Force white text on blue buttons */
    .bg-gradient-to-r.from-blue-600.to-indigo-600 *,
    .bg-gradient-to-r.from-blue-700.to-indigo-700 *,
    .bg-blue-600 *, 
    .bg-blue-700 * {
        color: white !important;
    }
    
    /* Badge styling */
    .badge {
        @apply px-2 py-1 text-xs font-semibold rounded-full;
    }
    
    .badge-success {
        @apply bg-green-100 text-green-800;
    }
    
    .badge-warning {
        @apply bg-yellow-100 text-yellow-800;
    }
    
    .badge-danger {
        @apply bg-red-100 text-red-800;
    }
    
    /* Dark mode overrides - forcefully disable any dark mode styles */
    .dark .bg-gradient-to-r.from-red-500.to-red-600,
    .dark .bg-gradient-to-r.from-red-600.to-red-700,
    .dark .bg-gradient-to-r.from-indigo-500.to-indigo-600,
    .dark .bg-gradient-to-r.from-indigo-600.to-indigo-700,
    .dark .bg-gradient-to-r.from-blue-600.to-indigo-600,
    .dark .bg-gradient-to-r.from-blue-700.to-indigo-700,
    .dark .bg-blue-600, 
    .dark .bg-blue-700 {
        color: white !important;
    }
    
    /* Special styling for MENU UTAMA */
    .bg-blue-600.text-black, 
    .bg-blue-700.text-black {
        color: white !important;
    }
    
    /* Enhanced Edit button styling */
    .btn-edit {
        background-image: linear-gradient(to right, #3b82f6, #2563eb) !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.2) !important;
        border: 1px solid #2563eb !important;
    }
    
    .btn-edit:hover {
        background-image: linear-gradient(to right, #2563eb, #1d4ed8) !important;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.2) !important;
        transform: translateY(-1px);
    }
    
    .btn-edit * {
        color: white !important;
    }
    
    /* Enhanced Delete button styling */
    .btn-delete {
        background-image: linear-gradient(to right, #ef4444, #dc2626) !important;
        color: white !important;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3), 0 2px 4px -1px rgba(239, 68, 68, 0.2) !important;
        border: 1px solid #dc2626 !important;
    }
    
    .btn-delete:hover {
        background-image: linear-gradient(to right, #dc2626, #b91c1c) !important;
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3), 0 4px 6px -2px rgba(239, 68, 68, 0.2) !important;
        transform: translateY(-1px);
    }
    
    .btn-delete * {
        color: white !important;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight flex items-center">
            <i class="fas fa-tachometer-alt mr-2"></i>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md text-gray-800 h-screen p-4 border-r border-gray-200">
            <div class="flex items-center justify-center mb-8 p-2 border-b border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Portal Berita</h1>
            </div>
            <nav>
                <ul>
                    <li class="mb-4">
                        <button onclick="showSection('dashboard-content')" class="dashboard-btn w-full text-left p-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 rounded-lg transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </button>
                    </li>
                    <li class="mb-4">
                        <!-- Post Berita with dropdown -->
                        <div class="relative">
                            <button onclick="toggleDropdown('post-berita-dropdown')" class="post-berita-btn w-full text-left p-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 rounded-lg transition-all duration-200 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <span>Post Berita</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 dropdown-icon text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="post-berita-dropdown" class="pl-4 mt-2 hidden">
                                <a href="#" onclick="showSection('post-berita-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Post Berita
                                </a>
                                @if(auth()->user()->role == 'admin')
                                <a href="#" onclick="showSection('list-berita-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    List Berita
                                </a>
                                <a href="#" onclick="showSection('kategori-berita-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Kategori Berita
                                </a>
                                @endif
                                <a href="#" onclick="showSection('pengajuan-berita-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Pengajuan Berita
                                </a>
                            </div>
                        </div>
                    </li>
                    @if(auth()->user()->role == 'admin')
                    <li class="mb-4">
                        <!-- Data User with dropdown -->
                        <div class="relative">
                            <button onclick="toggleDropdown('data-user-dropdown')" class="data-user-btn w-full text-left p-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 rounded-lg transition-all duration-200 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span>Data User</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 user-dropdown-icon text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="data-user-dropdown" class="pl-4 mt-2 hidden">
                                <a href="#" onclick="showSection('list-user-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    Daftar User
                                </a>
                                <a href="#" onclick="showSection('add-user-content')" class="block p-3 hover:bg-blue-50 text-gray-600 hover:text-blue-600 rounded-lg mb-2 flex items-center transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah User
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    <li class="mb-4">
                        <!-- Komentar -->
                        <button onclick="showSection('komentar-content')" class="komentar-btn w-full text-left p-3 hover:bg-blue-50 text-gray-700 hover:text-blue-600 rounded-lg transition-all duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <span>Manajemen Komentar</span>
                        </button>
                    </li>
                    @endif
                
                    <li class="mt-8">
                        <a href="{{ route('menu_utama') }}" class="w-full text-left p-3 bg-blue-600 hover:bg-blue-700 text-black rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-1 font-bold text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-medium">MENU UTAMA</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
            <!-- Traffic Dashboard -->
            <div id="dashboard-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-600"></i>
                    Traffic Dashboard
                </h3>
                
                @if(auth()->user()->role == 'admin')
                <!-- Tampilan lengkap untuk admin -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Total Berita Card -->
                    <div class="dashboard-card gradient card-blue rounded-xl p-5 relative">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-white">Total Berita</h4>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-newspaper text-xl"></i>
                        </div>
                        <p class="text-3xl mt-4 text-white font-bold">{{ $postCount }}</p>
                        <div class="text-blue-100 text-sm mt-2">Artikel tersedia</div>
                    </div>
                    
                    <!-- Total Pengguna Card -->
                    <div class="dashboard-card gradient card-green rounded-xl p-5 relative">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-white">Total Pengguna</h4>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <p class="text-3xl mt-4 text-white font-bold">{{ $userCount }}</p>
                        <div class="text-green-100 text-sm mt-2">Pengguna terdaftar</div>
                    </div>
                    
                    <!-- Total Kategori Card -->
                    <div class="dashboard-card gradient card-amber rounded-xl p-5 relative">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-white">Total Kategori</h4>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-tag text-xl"></i>
                        </div>
                        <p class="text-3xl mt-4 text-white font-bold">{{ $categoryCount }}</p>
                        <div class="text-amber-100 text-sm mt-2">Kategori tersedia</div>
                    </div>
                    
                    <!-- Pengunjung Hari Ini Card -->
                    <div class="dashboard-card gradient card-indigo rounded-xl p-5 relative">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-white">Pengunjung Hari Ini</h4>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-eye text-xl"></i>
                        </div>
                        <p class="text-3xl mt-4 text-white font-bold">{{ $visitorToday }}</p>
                        <div class="text-indigo-100 text-sm mt-2">Kunjungan baru</div>
                    </div>
                    
                    <!-- Total Pengunjung Card -->
                    <div class="dashboard-card gradient card-rose rounded-xl p-5 relative">
                        <div class="flex items-center justify-between">
                            <h4 class="text-lg font-semibold text-white">Total Pengunjung</h4>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-chart-bar text-xl"></i>
                        </div>
                        <p class="text-3xl mt-4 text-white font-bold">{{ $visitorTotal }}</p>
                        <div class="text-red-100 text-sm mt-2">Total kunjungan</div>
                    </div>
                </div>

                <!-- Analisis Frekuensi Kata -->
                <div class="mt-8 bg-white p-6 rounded-xl border border-gray-200 shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-chart-pie mr-2 text-blue-600"></i>
                            Analisis Frekuensi Kata dalam Artikel
                        </h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            Data Mining Sederhana
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Bar Chart for Word Frequency -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <h4 class="text-sm uppercase text-gray-500 font-semibold mb-3">20 Kata Terpopuler</h4>
                            <div class="word-frequency-chart" style="height: 250px;">
                                <canvas id="wordFrequencyChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Word Cloud -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <h4 class="text-sm uppercase text-gray-500 font-semibold mb-3">Word Cloud</h4>
                            <div class="word-cloud-container" style="height: 250px; position: relative;">
                                <div id="wordCloud" class="word-cloud"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table of Word Frequency Data -->
                    <div class="mt-6">
                        <h4 class="text-sm uppercase text-gray-500 font-semibold mb-3">Data Frekuensi Kata</h4>
                        <div class="overflow-hidden rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kata</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frekuensi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($wordFrequency ?? [] as $word => $count)
                                    <tr>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $word }}</td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ $count }}</td>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">
                                            @if(isset($totalWords) && $totalWords > 0)
                                                {{ number_format(($count / $totalWords) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    @if(empty($wordFrequency))
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada data analisis kata tersedia
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent News -->
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-newspaper mr-2 text-blue-600"></i>
                            Berita Terbaru
                        </h3>
                        <span class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg shadow-md flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </span>
                    </div>
                    <div class="overflow-hidden rounded-lg border border-gray-200 shadow-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-800">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Penulis</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($posts->take(5) as $post)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ Str::limit($post->title, 40) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $post->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $post->user->name ?? 'Admin' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $post->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada berita terbaru
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <!-- Tampilan terbatas untuk user biasa -->
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 mb-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-blue-800">Selamat datang di Portal Berita!</h3>
                            <p class="text-blue-600 mt-1">Anda saat ini login sebagai pengguna biasa dengan akses terbatas.</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Menu Post Berita -->
                    <a href="#" onclick="showSection('post-berita-content')" class="bg-white hover:bg-blue-50 border border-gray-200 p-6 rounded-xl shadow-sm transition-all duration-200 flex items-start">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Post Berita</h3>
                            <p class="text-gray-600 mt-1">Buat dan publikasikan berita baru untuk dilihat pengunjung portal.</p>
                            <div class="mt-4 inline-flex items-center text-blue-600 font-medium">
                                Mulai posting <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Menu Pengajuan Berita -->
                    <a href="#" onclick="showSection('pengajuan-berita-content')" class="bg-white hover:bg-blue-50 border border-gray-200 p-6 rounded-xl shadow-sm transition-all duration-200 flex items-start">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-800">Pengajuan Berita</h3>
                            <p class="text-gray-600 mt-1">Lihat status pengajuan berita yang telah Anda buat sebelumnya.</p>
                            <div class="mt-4 inline-flex items-center text-blue-600 font-medium">
                                Lihat pengajuan <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Analisis Frekuensi Kata untuk User -->
                <div class="mt-6 mb-8 bg-white p-6 rounded-xl border border-gray-200 shadow-md">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-chart-pie mr-2 text-blue-600"></i>
                            Analisis Frekuensi Kata dalam Artikel
                        </h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                            Data Mining Sederhana
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Bar Chart for Word Frequency -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <h4 class="text-sm uppercase text-gray-500 font-semibold mb-3">20 Kata Terpopuler</h4>
                            <div class="word-frequency-chart" style="height: 250px;">
                                <canvas id="wordFrequencyChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Word Cloud -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                            <h4 class="text-sm uppercase text-gray-500 font-semibold mb-3">Word Cloud</h4>
                            <div class="word-cloud-container" style="height: 250px; position: relative;">
                                <div id="wordCloud" class="word-cloud"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="bg-blue-50 p-3 rounded-lg border border-blue-100">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-lightbulb mr-2"></i>
                                <strong>Insight:</strong> Visualisasi di atas menunjukkan kata-kata yang paling sering muncul dalam artikel berita di portal ini. Data ini membantu mengidentifikasi tema dan topik populer.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-xl shadow-md">
                    <h3 class="text-xl font-bold mb-2 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi
                    </h3>
                    <p class="mb-4">Sebagai pengguna dengan role "user", Anda memiliki akses terbatas ke Dashboard.</p>
                    <p>Anda dapat melakukan posting berita dan melihat status pengajuan berita yang sudah Anda ajukan.</p>
                </div>
                @endif
            </div>

            <!-- Post Berita Form -->
            <div id="post-berita-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-blue-600"></i>
                    Tambah Berita
                </h3>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Judul Berita</label>
                        <input type="text" name="title" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul berita">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Konten Berita</label>
                        <textarea name="content" id="editor" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" rows="6" placeholder="Tulis isi berita di sini..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Wajib memilih kategori</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Gambar Berita</label>
                        <div class="relative w-full">
                            <input type="file" id="image-upload" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)" />
                            <div class="py-3 px-4 border border-gray-300 rounded-md bg-white shadow-sm text-sm leading-5 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center">
                                <i class="fas fa-upload mr-2 text-blue-500"></i>
                                <span id="file-name-display">Pilih File</span>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG. Maks 2MB</p>
                        </div>
                        
                        <!-- Image Preview - Setelah upload file -->
                        <div id="image-preview-wrapper" class="mt-4 hidden">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar:</p>
                            <div class="relative border rounded-lg overflow-hidden bg-gray-100" style="max-height: 200px;">
                                <img id="preview-image" src="#" alt="Preview Gambar" class="max-h-full max-w-full mx-auto object-contain">
                            </div>
                            <div id="image-info" class="mt-2">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                    <span id="file-details"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Publish Berita
                    </button>
                </form>
            </div>

            <!-- List Berita Content -->
            <div id="list-berita-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-newspaper mr-2 text-blue-600"></i>
                    Daftar Berita
                </h3>
                <div class="mb-5 flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="text" placeholder="Cari berita..." class="w-64 py-2 px-4 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-r-lg flex items-center">
                            Cari
                        </button>
                    </div>
                    <a href="#" onclick="showSection('post-berita-content')" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition-all duration-200">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Berita
                    </a>
                </div>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($posts as $index => $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ Str::limit($post->title, 40) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $post->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn-edit font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada berita yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> 1 </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> 3 </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Kategori Berita Content -->
            <div id="kategori-berita-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-tags mr-2 text-blue-600"></i>
                    Kategori Berita
                </h3>
                <div class="mb-6 p-5 bg-blue-50 rounded-lg border border-blue-100">
                    <h4 class="text-lg font-medium mb-3 text-gray-800">Tambah Kategori Baru</h4>
                    <form action="{{ route('categories.store') }}" method="POST" class="flex flex-wrap md:flex-nowrap gap-4">
                        @csrf
                        <input type="text" name="name" placeholder="Nama Kategori" class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow-sm transition-all duration-200 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Tambah Kategori
                        </button>
                    </form>
                </div>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Jumlah Berita</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categoriesWithCount as $index => $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $category->posts_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $category->posts_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada kategori yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pengajuan Berita Content -->
            <div id="pengajuan-berita-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-file-import mr-2 text-blue-600"></i>
                    Pengajuan Berita
                </h3>
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Pengirim</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                                @if(auth()->user()->role == 'admin')
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($submissions as $index => $submission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ Str::limit($submission->title, 40) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $submission->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $submission->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($submission->status == 'approved')
                                        <span class="badge badge-success">
                                            Approved
                                        </span>
                                    @elseif($submission->status == 'pending')
                                        <span class="badge badge-warning">
                                            Pending
                                        </span>
                                    @elseif($submission->status == 'declined')
                                        <span class="badge badge-danger">
                                            Declined
                                        </span>
                                    @endif
                                </td>
                                @if(auth()->user()->role == 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('posts.update-status', $submission->id) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center relative">
                                            <select name="status" class="status-select block w-full pl-3 pr-8 py-2 text-sm border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" data-id="{{ $submission->id }}">
                                                <option value="pending" {{ $submission->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $submission->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                                <option value="declined" {{ $submission->status == 'declined' ? 'selected' : '' }}>Decline</option>
                                            </select>
                                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role == 'admin' ? 6 : 5 }}" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan berita yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- List User Content -->
            <div id="list-user-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-users mr-2 text-blue-600"></i>
                    Data User
                </h3>
                <div class="mb-5 flex justify-between items-center">
                    <div class="flex items-center">
                        <input type="text" id="search-user" placeholder="Cari user..." class="w-64 py-2 px-4 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-r-lg flex items-center">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                    </div>
                    <a href="#" onclick="showSection('add-user-content')" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition-all duration-200">
                        <i class="fas fa-user-plus mr-2"></i>
                        Tambah User
                    </a>
                </div>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal Registrasi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users ?? [] as $index => $user)
                            <tr class="hover:bg-gray-50" data-user-id="{{ $user->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn-edit font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id ?? 0) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data user yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> 1 </a>
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600"> 2 </span>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"> 3 </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Add User Content -->
            <div id="add-user-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-user-plus mr-2 text-blue-600"></i>
                    Tambah User Baru
                </h3>
                <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Konfirmasi password" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Role</label>
                        <select name="role" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>
                            Tambah User
                        </button>
                        <button type="reset" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-all duration-300">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Komentar Content -->
            <div id="komentar-content" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hidden">
                <h3 class="text-xl font-bold mb-6 text-gray-800 flex items-center">
                    <i class="fas fa-comments mr-2 text-blue-600"></i>
                    Manajemen Komentar
                </h3>
                
                <div class="overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Komentar</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Pengirim</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Berita</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse(App\Models\Comment::with(['post', 'user'])->latest()->get() as $index => $comment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ Str::limit($comment->content, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $comment->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('posts.baca', $comment->post) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-2 py-1 rounded-md truncate max-w-xs block font-medium">
                                        {{ Str::limit($comment->post->title, 40) }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete font-semibold px-3 py-2 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada komentar yang tersedia</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    
    <!-- Trumbowyg Rich Text Editor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js"></script>
    <!-- Chart.js untuk visualisasi -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- D3.js dan d3-cloud untuk Word Cloud -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3-cloud@1.2.5/build/d3.layout.cloud.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Trumbowyg editor with better styling
            $('#editor').trumbowyg({
                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'],
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                ],
                autogrow: true,
                resetCss: true
            });
            
            // Set active state for buttons
            $('.dashboard-btn').addClass('bg-blue-50 text-blue-600');
            
            // Show dashboard content by default
            $('#dashboard-content').removeClass('hidden');
            $('#post-berita-content, #list-berita-content, #kategori-berita-content, #pengajuan-berita-content, #list-user-content, #add-user-content').addClass('hidden');
            
            // Inisialisasi visualisasi analisis frekuensi kata jika data tersedia
            initWordFrequencyVisualizations();
        });

        function showSection(sectionId) {
            // Hide all sections first
            $('#dashboard-content, #post-berita-content, #list-berita-content, #kategori-berita-content, #pengajuan-berita-content, #list-user-content, #add-user-content, #komentar-content').addClass('hidden');
            
            // Show the selected section
            $('#' + sectionId).removeClass('hidden');
            
            // Update active state for buttons
            $('.dashboard-btn, .post-berita-btn, .komentar-btn').removeClass('bg-blue-50 text-blue-600');
            
            if (sectionId === 'dashboard-content') {
                $('.dashboard-btn').addClass('bg-blue-50 text-blue-600');
                // Reinitialize visualizations when showing dashboard
                initWordFrequencyVisualizations();
            } else if (sectionId === 'post-berita-content') {
                $('.post-berita-btn').addClass('bg-blue-50 text-blue-600');
                $('#editor').trumbowyg('destroy');
                $('#editor').trumbowyg({
                    btns: [
                        ['viewHTML'],
                        ['undo', 'redo'],
                        ['formatting'],
                        ['strong', 'em', 'del'],
                        ['superscript', 'subscript'],
                        ['link'],
                        ['insertImage'],
                        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                        ['unorderedList', 'orderedList'],
                        ['horizontalRule'],
                        ['removeformat'],
                        ['fullscreen']
                    ],
                    autogrow: true,
                    resetCss: true
                });
            } else if (sectionId === 'komentar-content') {
                $('.komentar-btn').addClass('bg-blue-50 text-blue-600');
            }
        }

        function toggleDropdown(dropdownId) {
            $('#' + dropdownId).toggleClass('hidden');
            
            // Toggle the dropdown icon
            const dropdownIcon = document.querySelector('.dropdown-icon');
            if ($('#' + dropdownId).hasClass('hidden')) {
                dropdownIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
            } else {
                dropdownIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
            }
        }
        
        // File input preview
        $('input[type="file"]').on('change', function() {
            const file = this.files[0];
            const fileName = file ? file.name : 'No file chosen';
            $(this).next().find('span').text(fileName);
        });
        
        // Update status classes for visual indicators
        $('.status-select').on('change', function() {
            const status = $(this).val();
            const row = $(this).closest('tr');
            const statusBadge = row.find('td:nth-child(5) span');
            
            statusBadge.removeClass('badge-success badge-warning badge-danger');
            
            if (status === 'approved') {
                statusBadge.addClass('badge-success');
                statusBadge.text('Approved');
            } else if (status === 'pending') {
                statusBadge.addClass('badge-warning');
                statusBadge.text('Pending');
            } else if (status === 'declined') {
                statusBadge.addClass('badge-danger');
                statusBadge.text('Declined');
            }
        });
        
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const fileName = file.name;
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-image').attr('src', e.target.result);
                    $('#image-preview-wrapper').removeClass('hidden');
                    $('#file-details').text(fileName + ' (' + Math.round(file.size / 1024) + ' KB)');
                    $('#file-name-display').text(fileName);
                }
                reader.readAsDataURL(file);
            }
        }
        
        // Fungsi untuk inisialisasi visualisasi frekuensi kata
        function initWordFrequencyVisualizations() {
            // Data frekuensi kata dari controller
            const wordFrequencyData = {
                @if(!empty($wordFrequency))
                    @foreach($wordFrequency as $word => $count)
                        "{{ $word }}": {{ $count }},
                    @endforeach
                @endif
            };
            
            // Buat array data untuk Chart.js
            const words = Object.keys(wordFrequencyData);
            const counts = Object.values(wordFrequencyData);
            
            if (words.length > 0) {
                // Inisialisasi bar chart
                initBarChart(words, counts);
                
                // Inisialisasi word cloud
                initWordCloud(wordFrequencyData);
            }
        }
        
        // Bar Chart untuk frekuensi kata
        function initBarChart(words, counts) {
            const ctx = document.getElementById('wordFrequencyChart');
            
            // Hapus chart sebelumnya jika ada
            if (window.wordFreqChart instanceof Chart) {
                window.wordFreqChart.destroy();
            }
            
            // Buat bar chart baru
            window.wordFreqChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: words,
                    datasets: [{
                        label: 'Frekuensi Kata',
                        data: counts,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Frekuensi: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Frekuensi'
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        }
        
        // Word Cloud untuk visualisasi kata
        function initWordCloud(wordFrequencyData) {
            // Bersihkan container sebelumnya
            d3.select("#wordCloud").html("");
            
            // Siapkan data untuk word cloud
            const wordCloudData = Object.keys(wordFrequencyData).map(word => {
                return {
                    text: word,
                    size: Math.min(50, 10 + (wordFrequencyData[word] * 5)) // Ukuran font proporsional dengan frekuensi
                };
            });
            
            if (wordCloudData.length > 0) {
                const width = document.getElementById('wordCloud').offsetWidth;
                const height = 250;
                
                // Buat layout word cloud
                const layout = d3.layout.cloud()
                    .size([width, height])
                    .words(wordCloudData)
                    .padding(5)
                    .rotate(() => Math.random() > 0.5 ? 0 : 90)
                    .fontSize(d => d.size)
                    .on("end", draw);
                
                layout.start();
                
                // Fungsi untuk menggambar word cloud
                function draw(words) {
                    d3.select("#wordCloud").append("svg")
                        .attr("width", width)
                        .attr("height", height)
                        .append("g")
                        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")")
                        .selectAll("text")
                        .data(words)
                        .enter().append("text")
                        .style("font-size", d => d.size + "px")
                        .style("font-family", "Arial")
                        .style("fill", () => {
                            const colors = ["#3B82F6", "#60A5FA", "#93C5FD", "#2563EB", "#1D4ED8"];
                            return colors[Math.floor(Math.random() * colors.length)];
                        })
                        .attr("text-anchor", "middle")
                        .attr("transform", d => "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")")
                        .text(d => d.text);
                }
            }
        }
    </script>
</x-app-layout>