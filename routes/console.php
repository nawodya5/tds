<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('classes:generate-sessions')
    ->dailyAt('00:10')
    ->withoutOverlapping();


Schedule::command('sessions:update-statuses')
    ->dailyAt('00:05')
    ->withoutOverlapping();
