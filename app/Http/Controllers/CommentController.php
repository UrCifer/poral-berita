<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        // Validasi input
        $request->validate([
            'content' => 'required|string'
        ]);

        // Simpan komentar (langsung approved)
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $request->content,
            'status' => 'approved' // Langsung approved
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Remove the comment.
     */
    public function destroy(Comment $comment)
    {
        // Periksa apakah user adalah pemilik komentar atau admin
        if (Auth::id() == $comment->user_id || Auth::user()->role == 'admin') {
            // Hapus komentar
            $comment->delete();
            return back()->with('success', 'Komentar berhasil dihapus.');
        }
        
        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
    }
}
