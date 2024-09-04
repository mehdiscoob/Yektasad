<?php

namespace App\Console;

use App\Console\Commands\ClearExpiredCarts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ClearExpiredCarts::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('carts:clear-expired')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        require base_path('routes/console.php');
    }
}
