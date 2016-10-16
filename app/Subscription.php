<?php

namespace App;

use App\Series;
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
}
