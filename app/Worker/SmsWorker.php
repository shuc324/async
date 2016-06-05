<?php
/**
 * this source file is SmsWorker.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 17-13
 */
use App\Traits\Schedule;

class SmsWorker
{
    use Schedule;

    public function send($message)
    {
        var_dump($message);
    }
}