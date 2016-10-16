<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $fillable = ['id', 'title', 'data'];
    protected $casts = [
        'data' => 'object'
    ];

    public static function createOrUpdateFromApi($series)
    {
        $instance = self::updateOrCreate([
            'id' => $series['id']
        ], [
            'title' => $series['title'],
            'data' => $series
        ]);

        return $instance;
    }
}
