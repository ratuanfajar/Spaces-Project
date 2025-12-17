<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocusSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task',
        'duration',
        'mode',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}