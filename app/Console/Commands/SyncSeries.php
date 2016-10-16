<?php

namespace App\Console\Commands;

use App\Jobs\PullSeriesPageFromApi;
use App\Marvel\Series;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class SyncSeries extends Command
{
    protected $signature = 'marvel:syncseries {since}';

    protected $description = 'Sync Series from Marvel since specified date.';

    public function handle(Series $marvelSeries)
    {
        try {
            $since = new Carbon($this->argument('since'));
        } catch (Exception $e) {
            return $this->error('Sorry, but that is not a valid date/time for the "since" parameter.');
        }

        $params = ['modifiedSince' => $since->format('c')];
        $pageCount = $marvelSeries->pageCount($params);

        collect(range(1, $pageCount))->each(function ($page) use ($params) {
            dispatch(new PullSeriesPageFromApi($page, $params));
        });
    }
}
