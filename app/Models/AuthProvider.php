<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthProvider extends Model
{
    protected $guarded = [];

    protected $casts = [
        'login_at' => 'datetime',
    ];
}
