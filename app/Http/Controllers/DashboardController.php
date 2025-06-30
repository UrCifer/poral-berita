<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah total berita, pengguna, dan kategori
        $postCount = Post::count();
        $userCount = User::count();
        $categoryCount = Category::count();

        // Mengambil semua kategori untuk dropdown "Post Berita"
        $categories = Category::all();
        
        // Mengambil semua kategori beserta jumlah berita di setiap kategori
        $categoriesWithCount = Category::withCount('posts')->get();
        
        // Mengambil semua posts untuk List Berita
        $posts = Post::with(['category', 'user'])->get();
        
        // Mengambil pengajuan berita berdasarkan status dan user yang login
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Admin dapat melihat semua pengajuan
            $submissions = Post::with(['category', 'user'])->get();
        } else {
            // User biasa hanya melihat pengajuan mereka sendiri
            $submissions = Post::with(['category', 'user'])
                ->where('user_id', Auth::id())
                ->get();
        }
        
        // Mengambil semua data user untuk halaman Data User
        $users = User::all();

        // Mengambil semua komentar untuk halaman Manajemen Komentar
        $comments = Comment::with(['post', 'user'])->latest()->get();
        
        // Statistik pengunjung
        $visitorToday = Visitor::whereDate('created_at', Carbon::today())->count();
        $visitorTotal = Visitor::count();
        
        $monthlyVisitors = [];
        $browserStats = [];
        
        // Menghitung jumlah pengunjung per bulan (6 bulan terakhir)
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Visitor::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)
                        ->count();
            $monthlyVisitors[$month->format('M Y')] = $count;
        }
        
        // Menghitung statistik browser
        $browsers = Visitor::select('browser')->get();
        $tempStats = [];
        foreach($browsers as $browser) {
            if(isset($browser->browser)) {
                $browserName = $browser->browser;
                if (!isset($tempStats[$browserName])) {
                    $tempStats[$browserName] = 0;
                }
                $tempStats[$browserName]++;
            }
        }
        
        foreach($tempStats as $browser => $count) {
            $browserStats[] = [
                'name' => $browser,
                'count' => $count,
                'percentage' => round(($count / max(1, count($browsers))) * 100, 1)
            ];
        }
        
        // Analisis Frekuensi Kata dalam Artikel (Data Mining Sederhana)
        $wordFrequency = $this->analyzeWordFrequency();
        $totalWords = array_sum($wordFrequency);
        
        return view('dashboard', compact(
            'postCount', 
            'userCount', 
            'categoryCount', 
            'categories', 
            'categoriesWithCount',
            'browserStats', 
            'monthlyVisitors', 
            'visitorToday', 
            'visitorTotal',
            'posts',
            'submissions',
            'users',
            'comments',
            'wordFrequency',
            'totalWords'
        ));
    }
    
    /**
     * Analisis frekuensi kata dalam semua artikel berita (Data Mining Sederhana)
     * 
     * @return array
     */
    private function analyzeWordFrequency()
    {
        // Mengambil semua konten artikel
        $articles = Post::pluck('content')->toArray();
        
        // Kata-kata yang akan diabaikan (stopwords)
        $stopwords = [
            'yang', 'dan', 'di', 'dengan', 'untuk', 'pada', 'ke', 'dari', 'dalam', 'ini', 'itu',
            'oleh', 'ada', 'tidak', 'akan', 'juga', 'saya', 'kamu', 'kami', 'mereka', 'bisa', 'dapat',
            'adalah', 'tersebut', 'jika', 'kalau', 'atau', 'secara', 'agar', 'sebagai', 'telah', 'sudah',
            'seperti', 'hanya', 'bahwa', 'namun', 'tetapi', 'hingga', 'karena', 'ketika', 'maka', 'sedang',
            'para', 'per', 'ia', 'nya', 'kepada', 'lalu', 'sejak', 'tanpa', 'lebih', 'masih', 'harus',
            'lain', 'beberapa', 'sekitar'
        ];
        
        // Menggabungkan semua konten artikel
        $allWords = [];
        foreach ($articles as $article) {
            // Bersihkan HTML tags
            $text = strip_tags($article);
            // Ubah ke lowercase dan hapus karakter non-alfabet
            $text = preg_replace('/[^a-z0-9 ]/i', '', strtolower($text));
            // Pecah menjadi kata-kata
            $words = explode(' ', $text);
            
            foreach ($words as $word) {
                $word = trim($word);
                // Abaikan kata kosong atau terlalu pendek
                if (strlen($word) <= 2 || in_array($word, $stopwords) || is_numeric($word)) {
                    continue;
                }
                
                if (!isset($allWords[$word])) {
                    $allWords[$word] = 0;
                }
                $allWords[$word]++;
            }
        }
        
        // Urutkan dari yang terbanyak
        arsort($allWords);
        
        // Ambil 20 kata terpopuler
        return array_slice($allWords, 0, 20, true);
    }
}