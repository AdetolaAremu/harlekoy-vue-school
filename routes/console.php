<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('upload-batch-command')
    ->everyMinute()
    ->withoutOverlapping()
    ->then(function () {
        sleep(70);
        Artisan::call('upload:batch-records');
    });
