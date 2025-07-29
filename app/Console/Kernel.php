<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // Optional: Include routes/console.php commands
        require base_path('routes/console.php');
    }

    /**
     * Define the application's command schedule.
     */
    protected $commands = [
    \App\Console\Commands\SendJobAlerts::class,
];

protected function schedule(Schedule $schedule)
{
    $schedule->command('alerts:send')->daily();
}
}
