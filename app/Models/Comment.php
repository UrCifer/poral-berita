<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'status'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'approved', // Set default status to approved
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
