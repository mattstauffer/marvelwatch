<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUsersOfNewComics as NotifyUsersOfNewComicsJob;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyUsersOfNewComics extends Command
{
    protected $signature = 'marvel:notify';

    protected $description = 'Notify users of new comics in all subscribed series';

    public function handle()
    {
        dispatch(new NotifyUsersOfNewComicsJob);
    }
}
