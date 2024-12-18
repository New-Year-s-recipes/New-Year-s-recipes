<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouncilEvaluation extends Model
{
    use HasFactory;

    // Указываем имя таблицы, если оно не соответствует конвенциям Laravel
    protected $table = 'council_evaluation';

    // Указываем, какие поля можно массово заполнять
    protected $fillable = [
        'users_id',
        'rating',
        'tips_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function tip()
    {
        return $this->belongsTo(Tip::class, 'tips_id');
    }
}
