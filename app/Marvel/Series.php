<?php

namespace App\Marvel;

use Marvel\Client;

class Series
{
    private $marvel;
    private $cacheLength = 60;
    private $pageLength = 100;

    public function __construct(Client $marvel)
    {
        $this->marvel = $marvel;
    }

    public function all()
    {
        return cache()->remember('series', $this->cacheLength, function () {
            return $this->allFromApi();
        });
    }

    private function allFromApi()
    {
        return collect(range(1, $this->countSeries()))->flatMap(function ($page) {
            return $this->seriesPageFromApi($page);
        });
    }

    private function seriesPageFromApi($page)
    {
        return $this->marvel->series->index(
            $page - 1,
            $this->pageLength
        )->data;
    }

    private function countSeries()
    {
        $countItems = $this->marvel->series->index(1, 1)->total;
        return intval(ceil($countItems / $this->pageLength));
    }
}
