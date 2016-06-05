<?php
/**
 * this source file is helper.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 15-08
 */

use App\Utils\Logger;

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        return strpos($value, '"') === 0 && '"' === substr($value, -strlen('"')) ? substr($value, 1, -1) : $value;
    }
}

if (!function_exists('gearman_error_handler')) {
    function gearman_error_handler($err_no, $err_str, $err_file, $err_line)
    {
        $logger = Logger::withName('system');
        $logger->error("code($err_no) $err_file + $err_line: $err_str");
    }
}