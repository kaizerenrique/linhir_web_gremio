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

    public function lifetimeStatistics()
    {
        return $this->hasOne(LifetimeStatistics::class, 'personaje_id');
    }

    public function gatheringStatistics()
    {
        return $this->hasOne(GatheringStatistics::class, 'personaje_id');
    }
}
