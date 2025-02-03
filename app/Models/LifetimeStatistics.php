<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LifetimeStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'personaje_id',
        'PvE_Total',
        'PvE_Royal',
        'PvE_Outlands',
        'PvE_Avalon',
        'PvE_Hellgate',
        'PvE_CorruptedDungeon',
        'PvE_Mists',
        'Crafting_Total',
        'Crafting_Royal',
        'Crafting_Outlands',
        'Crafting_Avalon',
        'CrystalLeague',
        'FishingFame',
        'FarmingFame',
        'Timestamp_Conec',
    ];

    // Relación con el personaje
    public function personaje()
    {
        return $this->belongsTo(Personaje::class, 'personaje_id');
    }

    // Relación con las estadísticas de recolección
    public function gatheringStatistics()
    {
        return $this->hasMany(GatheringStatistics::class);
    }
}
