<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory,Notifiable;
    
    protected $table = 'content.categories';

    protected $fillable = [
        'title',
        'slug'
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class,
            'content.category_movie',
            'category_id',
            'movie_id'
        );
    }
}
