<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'image', 'is_pinned'];

    // Format tanggal agar enak dibaca di JSON (Frontend)
    protected $casts = [
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
}