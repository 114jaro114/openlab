<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\ApiController;
use App\Console\Commands\MqttStore;
use App\Console\Commands\MqttStore2;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
      MqttStore::class,
      MqttStore2::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(join('@', [ ApiController::class, 'store2']))->everyMinute();
        // $schedule->call(join('@', [ ApiController::class, 'store']))->everyMinute();
        //
        $schedule->command('MqttStore')->everyMinute()->withoutOverlapping();
        $schedule->command('MqttStore2')->everyMinute()->withoutOverlapping();

        // $schedule -> exec("php artisan command:mqtts1");
        // $schedule -> exec("php artisan command:mqtts2");

        // $schedule->call('App\Http\Controllers\ApiController@store')->everyMinute();
        // $schedule->call('App\Http\Controllers\ApiController@store2')->everyMinute();
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
