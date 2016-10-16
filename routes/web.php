<?php

use App\Marvel\Series;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', function () {
        $series = cache()->remember('seriesFromDb', 1, function () {
            return \App\Series::orderBy('title')->select(['id', 'title'])->get();
        });

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
});

Auth::routes();
