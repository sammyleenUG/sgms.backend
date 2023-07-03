<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bin extends Model
{
    use HasFactory;

    protected $fillable = [
        'bin_reference_number',
        'location',
        'supervisor_id',
        'bin_capacity',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['bin_level', 'air_quality'];

    public function AirQualities()
    {
        return $this->hasMany(BinLevel::class);
    }

    public function BinLevels()
    {
        return $this->hasMany(BinAirquality::class);
    }

    public function getBinLevelAttribute()
    {
        //calculate percentage.
        $bin_capacity = $this->bin_capacity;

        $bin_level = BinLevel::where('bin_id', $this->id)->latest('id')->value('bin_level') ?? ($bin_capacity + 1);

        if ($bin_level <  $bin_capacity) {
            $percentage = round((($bin_capacity - $bin_level) /  $bin_capacity) * 100, 2);
        } else {
            $percentage = 0;
        }


        return "$percentage%";
    }

    public function getAirQualityAttribute()
    {
        $air_quality = BinAirquality::where('bin_id', $this->id)->latest('id')->value('bin_air_quality') ?? 0;

        return "$air_quality%";
    }
}
