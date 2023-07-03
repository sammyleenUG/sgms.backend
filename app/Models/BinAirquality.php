<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinAirquality extends Model
{
    use HasFactory;

    protected $fillable = [
        'bin_id',
        'bin_air_quality',
        'created_at',
        'updated_at'
    ];

    public function AirQuality(){
        return $this->belongsTo(Bin::class);
    }
}
