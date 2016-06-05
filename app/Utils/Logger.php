<?php
/**
 * this source file is Logger.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 15-24
 */
namespace App\Utils;

use App\Traits\Macro;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as MongoLog;

class Logger
{
    use Macro;

    public static function init($channel, $filename)
    {
        $logger = new MongoLog($channel);
        $stream = new RotatingFileHandler($filename, 0, MongoLog::DEBUG);
        $stream->setFormatter(new LineFormatter("%datetime% [%channel%] %level_name% %message% %context%\n", "Y-m-d H:i:s"));
        $logger->pushHandler($stream);
        static::$object = $logger;
    }

    public function __call($method, $parameters)
    {
        static::init(Config::get('app.logger.channel'), Config::get('app.logger.filename'));

        return method_exists(static::$object, $method) && Config::get('app.logger.debug') ? call_user_func_array([static::$object, $method], $parameters) : null;
    }

    public static function __callStatic($method, $parameters)
    {
        static::init(Config::get('app.logger.channel'), Config::get('app.logger.filename'));

        return method_exists(static::$object, $method) && Config::get('app.logger.debug') ? call_user_func_array([static::$object, $method], $parameters) : null;
    }
}