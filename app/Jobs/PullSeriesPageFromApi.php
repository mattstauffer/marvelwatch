<?php

namespace App\Jobs;

use App\Marvel\Series;
use App\Series as SeriesModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullSeriesPageFromApi implements ShouldQueue
{
    private $page;
    private $params;

    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct($page, $params)
    {
        $this->page = $page;
        $this->params = $params;
    }

    public function handle(Series $seriesClient)
    {
        collect($seriesClient->forPage($this->page, $this->params))->each(function ($series) {
            $this->handleSeries($series);
        });
    }

    private function handleSeries($series)
    {
        SeriesModel::createOrUpdateFromApi($series);
    }
}
