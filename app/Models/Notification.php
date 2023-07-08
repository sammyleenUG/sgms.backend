<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'action',
        'category',
        'created_at',
    ];

    protected $appends = ['time_ago'];

    public function getTimeAgoAttribute(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
