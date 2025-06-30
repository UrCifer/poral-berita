<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'approved')->latest();
        
        // Filter by category if provided
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        $posts = $query->paginate(9);
        $categories = Category::all();
        
        return view('posts.semua_berita', compact('posts', 'categories'));
    }
    
    public function show(Post $post)
    {
        // Only show approved posts or if user is author/admin
        if ($post->status != 'approved' && 
            (!Auth::check() || (Auth::id() != $post->user_id && !Auth::user()->is_admin))) {
            abort(404);
        }
        
        // Get related posts from the same category
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();
            
        // Eager load comments with their users for performance
        $post->load(['comments' => function($query) {
            $query->with('user')->where('status', 'approved')->orderBy('created_at', 'desc');
        }]);
            
        return view('posts.baca_berita', compact('post', 'relatedPosts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post-images', 'public');
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Berita berhasil dikirim untuk ditinjau.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ];

        // Handle image upload if a new one is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            
            // Store new image
            $data['image'] = $request->file('image')->store('post-images', 'public');
        }

        $post->update($data);

        return redirect()->route('dashboard')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        // Delete the image if exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post
        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function updateStatus(Request $request, Post $post)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,declined',
        ]);
        
        $post->update([
            'status' => $request->status,
        ]);
        
        return redirect()->back()->with('success', 'Status berita berhasil diperbarui.');
    }
}
