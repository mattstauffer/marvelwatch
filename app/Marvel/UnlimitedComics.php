<?php

namespace App\Marvel;

use Marvel\Client;

class UnlimitedComics
{
    private $marvel;
    private $cacheLength = 60;
    private $pageLength = 100;
    private $baseParams = [
        'formatType' => 'comic',
        'noVariants' => true,
        'hasDigitalIssue' => true
    ];

    public function __construct(Client $marvel)
    {
        $this->marvel = $marvel;
    }

    public function bySeries($seriesId, $params = [])
    {
        // @todo what if 100+ comics in a series?
        return $this->pageBySeries($seriesId, 1, $params);
    }

    public function pageBySeries($seriesId, $page = 1, $params = [])
    {
        return $this->marvel->comics->index(
            $page,
            $this->pageLength,
            array_merge($this->baseParams, $params)
        )->data;
    }
}
