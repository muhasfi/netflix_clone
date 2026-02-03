<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Plan extends Model
{
    use HasFactory,Notifiable;

    protected $table ='billing.plans';
    protected $connection = 'pgsql';
    
    protected $fillable = [
        'title',
        'price',
        'duration',
        'resolution',
        'max_devices'
    ];

    public function membership()
    {
        return $this->hasMany(Membership::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships', 'plan_id', 'user_id');
    }
}
