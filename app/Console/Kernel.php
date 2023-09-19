<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('is:trigger-vcn-ingest')->everyFifteenMinutes()->runInBackground();
        $schedule->command('is:trigger-rcr-calls-ingest')->everyFifteenMinutes()->runInBackground();
        $schedule->command('is:trigger-rcr-iirs-ingest')->everyFifteenMinutes()->runInBackground();
        $schedule->command('is:trigger-rcr-do-schedule-ingest')->everyFifteenMinutes()->runInBackground();
        $schedule->command('is:trigger-rcr-dat-schedule-ingest')->everyThreeMinutes()->runInBackground();

        $schedule->command('is:trigger-outages-t1-ingest')->everyTenMinutes()->runInBackground();
        $schedule->command('is:trigger-outages-t2-ingest')->everyTenMinutes()->runInBackground();
        $schedule->command('is:trigger-outages-t3-ingest')->everyTenMinutes()->runInBackground();
        $schedule->command('is:trigger-outages-t4-ingest')->everyTenMinutes()->runInBackground();
        $schedule->command('is:trigger-outages-t5-ingest')->everyTenMinutes()->runInBackground();

        $schedule->command('is:get-temp-files')->everyFifteenMinutes();
        $schedule->command('is:get-temp-files')->everyFifteenMinutes();

        $schedule->command('is:get-weather-alerts')->everyFifteenMinutes(); //
        $schedule->command('is:get-weather-forecasts')->everyFifteenMinutes(); //

        $schedule->command('is:get-members-file')->everyMinute();
        $schedule->command('is:get-position-assignments-file')->everyMinute();
        $schedule->command('is:get-trainings-file')->everyMinute();
        $schedule->command('is:get-hours-file')->everyMinute();
        $schedule->command('is:get-calls-file')->everyMinute();
        $schedule->command('is:get-events-file')->everyMinute();
        $schedule->command('is:get-cases-file')->everyMinute();
        $schedule->command('is:get-clients-file')->everyMinute();
        $schedule->command('is:get-users-file')->everyMinute();


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
