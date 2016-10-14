<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NotifyUsersOfNewComics extends Command
{
    protected $signature = 'notify';

    protected $description = 'Notify users of new comics in all subscribed series';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Foreach subscription (group by series id)
        // Get list of comics
        // Check if any comics were added to Marvel Unlimited since the last time this job ran
        // If so, send out notification email (make sure to get every subscription for this series)
    }
}
