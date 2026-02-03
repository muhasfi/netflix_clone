<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Rating extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'content.ratings';

    protected $fillable = [
        'user_id',
        'movie_id',
        'rating'
    ];


    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
