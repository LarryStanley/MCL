<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();

         $schedule->call(function () {
            // get current time
            $dayWeek = date('w', time());
            $hour = (int)date('H', time());
            $hour = (string)$hour;
            $classValue = ["8" => "1", "9" => "2", "10" => "3", "4" => "11", "12" => "Z", "13" => "5", "14" => "6", "15" => "7", "16" => "8", "17" => "9", "18" => "A", "19" => "B", "20" => "C"];
            if (!empty($classValue[$hour]))
                $currentClass = $classValue[$hour];
            else
                $currentClass = "1";
            if ($dayWeek == 6 || $dayWeek == 7)
                $dayWeek = 1;
            $currentTimeValue = $dayWeek.$currentClass;

            $freshData = DB::table("class")->where('time_id', $currentTimeValue)->where("type", "fresh")->get();
            foreach ($freshData as $key => $value) {
                $signData = DB::table("signUpData")->whereBetween('signTime', array(date('Y-m-d 00:00:00', time()), date('Y-m-d 23:59:59', time())))->where("userId", $value->user_id)->first();
                if (!$signData) {
                    DB::table("signUpData")->insert(array(
                        "userId" => $value->user_id,
                        "status" => "absenteeism"
                    ));
                }
            }
        })->cron('20 * * * *');
    }
}
