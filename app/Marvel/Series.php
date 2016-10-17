<?php

namespace App\Marvel;

use Marvel\Client;

class Series
{
    private $marvel;
    private $cacheLength = 60;
    private $pageLength = 100;
    private $baseParams = ['seriesType' => 'ongoing', 'contains' => 'comic,digital comic,infinite comic'];

    public function __construct(Client $marvel)
    {
        $this->marvel = $marvel;
    }

    public function count($params = [])
    {
        return cache()->remember('seriesCount:' . md5(json_encode($params)), $this->cacheLength, function () use ($params) {
            return $this->marvel->series->index(1, 1, array_merge($this->baseParams, $params))->total;
        });
    }

    public function pageCount($params = [])
    {
        return cache()->remember('seriesPageCount:' . md5(json_encode($params)), $this->cacheLength, function () use ($params) {
            return intval(ceil($this->count($params) / $this->pageLength));
        });
    }

    public function forPage($page, $params = [])
    {
        return $this->marvel->series->index(
            $page - 1,
            $this->pageLength,
            array_merge($this->baseParams, $params)
        )->data;
    }

    public function find($id)
    {
        throw new \Exception('todo');
    }
}
