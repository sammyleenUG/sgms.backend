<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'bin_id',
        'bin_level',
        'created_at',
        'updated_at'
    ];

    public function BinLevel(){
        return $this->belongsTo(Bin::class);
    }
}
