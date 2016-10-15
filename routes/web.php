<?php

use App\Marvel\Series;

Auth::loginUsingId(1);

Route::get('/', function () {
    return view('welcome');
});

Route::get('series', function () {
    /*
    $series = cache()->remember('series', 60, function () use ($marvel) {
        return $marvel->series->index(1, 9999);
    });
    */
    // dd(app(Series::class)->all());

    // $series = $marvel->series->index(1000, 5);
    $series = app(Series::class)->all();

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
