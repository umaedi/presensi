<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        // clean backup
        $schedule->command('backup:clean')->daily()->at('01:00');
        // Backing up database
        $schedule->command('backup:run')->daily()->at('01:30');

        $schedule->command('backup:run --only-db')->daily()->at('12.30');
        $schedule->command('backup:run --only-db')->daily()->at('18.30');

        //move backup to root
        // $schedule->command('cp')->daily()->at('03:30');
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
