<?php

namespace App\Console;

use App\Model\BingImg;
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
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function (){
            //获取bing的每日一图
            $res = curl('https://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1',false,false,true);
            $res = json_decode($res,true);
            $bingImgArr = $res['images'][0];
            $bingImg = new BingImg();
            $bingImg->date = date('Y-m-d',strtotime($bingImgArr['enddate']));
            $url = 'https://cn.bing.com'.$bingImgArr['url'];
            $imgInfo = getimagesize($url);
            $imgData = file_get_contents($url);
            $base64_image = 'data:' . $imgInfo['mime'] . ';base64,' . chunk_split(base64_encode($imgData));
            $bingImg->base64 = $base64_image;
            $bingImg->save();
        })->dailyAt('06:00')->timezone('PRC');
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
