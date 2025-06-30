<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function index()
    {
        // Updated logic to ensure accurate post counts
        $categories = Category::withCount(['posts' => function ($query) {
            // Only count published/approved posts
            $query->where('status', 'approved');
        }])->get();
        
        return view('categories.daftar_kategori', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        // Buat kategori baru
        Category::create([
            'name' => $request->name
        ]);

        // Redirect kembali ke dashboard dengan notifikasi sukses
        return redirect()->route('dashboard')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        // Cek apakah kategori memiliki post
        if ($category->posts()->count() > 0) {
            return redirect()->route('dashboard')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki berita.');
        }

        // Hapus kategori
        $category->delete();

        // Redirect kembali ke dashboard dengan notifikasi sukses
        return redirect()->route('dashboard')->with('success', 'Kategori berhasil dihapus.');
    }
}
