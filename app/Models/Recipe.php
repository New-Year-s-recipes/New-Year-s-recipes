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
        'mini_description',
        'category',
        'status',
    ];

    protected $casts = [
        'data' => 'array', // Указываем, что 'data' будет храниться как массив
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    
}
