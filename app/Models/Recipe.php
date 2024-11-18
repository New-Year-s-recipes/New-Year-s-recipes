<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'data',
        'path',
        'complexity',
        'category',
    ];

    protected $casts = [
        'data' => 'array', // Указываем, что 'data' будет храниться как массив
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
