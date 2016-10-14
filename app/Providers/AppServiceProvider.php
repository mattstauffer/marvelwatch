<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Marvel\Client;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        // @todo: Cache stuff
        $this->app->bind(Client::class, function ($app) {
            return new Client(config('services.marvel.public'), config('services.marvel.private'));
        });
    }
}
