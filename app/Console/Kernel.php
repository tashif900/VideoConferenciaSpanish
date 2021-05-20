<?php

namespace App\Console;

use App\Console\Commands\ChangeStateAds;
use App\Console\Commands\Generatewithdrawals;
use App\WithdrawalPolicy;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendNotificatuinDayly;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendNotificationsEveryFiveMinutes;
use App\Console\Commands\SendNotificationsEverySixtyMinutes;
use App\Console\Commands\SendNotificationsEveryThirtyMinutes;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNotificationsEveryFiveMinutes::class,
        SendNotificationsEverySixtyMinutes::class,
        SendNotificationsEveryThirtyMinutes::class,
        SendNotificatuinDayly::class,
        ChangeStateAds::class,
        Generatewithdrawals::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('notification:fiveminute')->everyMinute();
        $schedule->command('notification:thirtyminute')->everyMinute();
        $schedule->command('notification:sixtyminute')->everyMinute();
        $schedule->command('notification:dayly')->everyMinute();
        $schedule->command('notification:dayly')->dailyAt('23:00');
        $schedule->command('registered:withdrawal_requests')
            ->dailyAt('01:00')
            ->when(function (){
                $policie = WithdrawalPolicy::all()->last();
                $dia_policie = $policie->start_day;
                $dia_actual = ucfirst (Carbon::now()->dayName);
                return $dia_policie == $dia_actual;
            });
    }



    /**
     * RegisterController the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
