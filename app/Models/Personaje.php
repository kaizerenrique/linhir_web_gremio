<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personaje extends Model
{
    protected $fillable = [
        'user_id',
        'Name',
        'Id_albion',
        'GuildId',
        'miembro'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
