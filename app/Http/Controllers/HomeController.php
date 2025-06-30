<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'approved');
        }])->get();
        
        // Menampilkan semua post yang sudah di-approve tanpa batasan
        $approvedPosts = Post::where('status', 'approved')->latest()->get();

        return view('menu_utama', compact('categories', 'approvedPosts'));
    }
    
    public function menuUtama()
    {
        $categories = Category::withCount(['posts' => function($query) {
            $query->where('status', 'approved');
        }])->get();
        
        // Menampilkan semua post yang sudah di-approve tanpa batasan
        $approvedPosts = Post::where('status', 'approved')->latest()->get();

        return view('menu_utama', compact('categories', 'approvedPosts'));
    }
    
    public function about()
    {
        return view('about');
    }
}
