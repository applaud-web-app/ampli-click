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
        $schedule->command('daily_logout:twice_a_day')->twiceDaily(1, 13)->sendOutputTo('command1.log');
        // $schedule->command('daily_logout:twice_a_day')->dailyAt("13:56")->sendOutputTo('command1.log');
        // $schedule->command('daily_logout:twice_a_day')->everyMinute()->sendOutputTo('command1.log');
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
