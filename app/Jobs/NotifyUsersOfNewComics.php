<?php

namespace App\Jobs;

use App\Mail\NewUnlimitedComic;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Marvel\Client;

class NotifyUsersOfNewComics implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $since;

    public function __construct()
    {
        // subday seems shaky but .. let's roll with it for now
        $this->since = Carbon::now()->subDay();
        // shit. core question: does a series get marked as odified if a new comic is released? if not this whole concept of starting witht he series is wrong
        $this->since = Carbon::now()->subWeek();
    }

    public function handle()
    {
        $this->updatedSeries()->filter(function ($series) {
            return $this->seriesIsSubscribed($series);
        })->each(function ($series) {
            $this->unlimitedComicsForSeries($series)->filter(function ($comic) {
                return $this->comicIsNewOnUnlimited($comic);
            })->each(function ($comic) use ($series) {
                $this->notify($series, $comic);
            });
        });
    }

    private function updatedSeries()
    {
        // for each series that was modified in the last day...
        // @todo: What if 100+ series updated in the last day?
        return collect(app(\App\Marvel\Series::class)->forPage(1), [
            'updatedSince' => $this->since->format('c')
        ]);
    }

    private function seriesIsSubscribed($series)
    {
        // @todo
        return true;
    }

    private function unlimitedComicsForSeries($series)
    {
        return collect(app(\App\Marvel\UnlimitedComics::class)->bySeries($series['id']));
    }

    private function comicIsNewOnUnlimited($comic)
    {
        return collect($comic['dates'])->filter(function ($date) {
            return $date['type'] == 'unlimitedDate';
        })->filter(function ($date) {
            return Carbon::createFromFormat('Y-m-d\TH:i:sO', $date['date'])->gt($this->since);
        })->count() > 0;
    }

    private function notify($series, $comic)
    {
        $subscribers = Subscription::where('series_id', $series['id'])->with('user')->get()->map(function ($subscription) {
            return $subscription->user->email;
        });

        // Mail::to($subscribers)->send(new NewUnlimitedComic($series, $comic));
    }
}
