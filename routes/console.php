<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Testing
Schedule::command('app:update-vacation-attendance')->everyTenSeconds();
// Schedule::command('app:update-vacation-attendance')->daily();
