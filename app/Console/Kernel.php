<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Payout;
use App\Proposal;
use App\User;
use DB;
use App\SiteManagement;
use App\Helper;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(
            function () {
                Helper::updatePayouts();
                // the message
                $msg = 'cron messag';

                // use wordwrap() if lines are longer than 70 characters
                $msg = wordwrap($msg, 70);

                // send email
                mail("ethtml03@gmail.com", "My subject", $msg);
            }
        )->everyMinute();
        // ->monthlyOn(28, '0:0');
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
