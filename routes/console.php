<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
|
| Hostinger shared hosting can't run a long-lived `queue:work` daemon, so we
| drain the queue from the scheduler instead. A single cron entry
| (`* * * * * php artisan schedule:run`) then powers both the scheduler and
| queued jobs (transactional emails, etc.). Time-sensitive queues are listed
| first so they never wait behind slower work (CLAUDE.md Section 15).
|
*/

Schedule::command('queue:work --stop-when-empty --max-time=55 --tries=3 --queue=emails,sms,notifications,default')
    ->everyMinute()
    ->withoutOverlapping();
