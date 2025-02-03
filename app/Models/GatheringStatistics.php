<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GatheringStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifetime_statistics_id',
        'resource_type',
        'Total',
        'Royal',
        'Outlands',
        'Avalon',
    ];

    // Relación con las estadísticas generales
    public function lifetimeStatistics()
    {
        return $this->belongsTo(LifetimeStatistics::class, 'lifetime_statistics_id');
    }
}
