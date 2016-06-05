<?php
/**
 * this source file is Config.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 14-36
 */
namespace App\Utils;

use App\Traits\Macro;

class Config
{
    use Macro;

    public static function init($object)
    {
        static::$object = $object;
    }
}