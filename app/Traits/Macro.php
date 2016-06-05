<?php
/**
 * this source file is Macro.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 14-39
 */
namespace App\Traits;

trait Macro
{
    static $object;

    public function __call($method, $parameters)
    {
        return method_exists($this, $method) ? call_user_func_array([$this, $method], $parameters) : null;
    }

    public static function __callStatic($method, $parameters)
    {
        return method_exists(static::$object, $method) ? call_user_func_array([static::$object, $method], $parameters) : null;
    }
}