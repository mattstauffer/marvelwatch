<?php

namespace App;

use App\Series;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'series_id'
    ];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
