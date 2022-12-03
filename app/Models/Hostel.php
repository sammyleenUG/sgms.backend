<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hostel extends Model
{
    use HasFactory;

    protected $fillable = [
        'h_name',
        'h_location',
        'h_lat',
        'h_long',
        'h_min_price',
        'h_max_price',
        'h_amenities',
        'h_imagepath',   
    ];
}
