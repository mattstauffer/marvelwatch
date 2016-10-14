<?php

use Marvel\Client;

Auth::loginUsingId(1);

Route::get('/', function () {
    return view('welcome');
});

Route::get('series', function (Client $marvel) {
    /*
    $series = cache()->remember('series', 60, function () use ($marvel) {
        return $marvel->series->index(1, 9999);
    });
    */

    $series = $marvel->series->index(1000, 5);

    return view('series')->with('series', $series);
});

Route::get('series/{id}/subscriptions/post', function ($seriesId) {
    Auth::user()->subscriptions()->create([
        'series_id' => $seriesId
    ]);

    return redirect()->back();
});

Route::get('series/{id}/subscriptions/delete', function ($seriesId) {
    Auth::user()->subscriptions()->where('series_id', $seriesId)->delete();

    return redirect()->back();
});

// cron that checks for new and emails

Auth::routes();
