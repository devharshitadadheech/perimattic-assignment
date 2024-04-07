<?php

namespace App\Console;

use App\Models\Site;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $sites = Site::all();
        $command = 'sites:check';
        foreach ($sites as $site) {
            $schedule->call(function () use ($command) {
                Artisan::call($command);
            })->cron($site->frequency);
        }
        // for birthday
        $schedule->call(function () {
            Artisan::call('birthday:notify');
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
