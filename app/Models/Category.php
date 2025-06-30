<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Pastikan kolom yang dapat diisi sesuai dengan database
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

