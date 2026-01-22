<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserDevice extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'auth.user_devices';
    protected $fillable = [
        'user_id',
        'device_name',
        'device_id',
        'device_type',
        'platform',
        'platform_version',
        'browser',
        'browser_version',
        'last_active'
    ];

    protected $casts = [
        'last_active' => 'datetime'
    ];


}
