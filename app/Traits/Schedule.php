<?php
/**
 * this source file is Schedule.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 17-51
 */
namespace App\Traits;

use GearmanJob;
use Exception;
use App\Utils\Logger;

trait Schedule
{
    public function run(GearmanJob $job, &$log)
    {
        set_error_handler('gearman_error_handler');

        $call_result = false;
        $workload = json_decode($job->workload(), true);

        try {
            $workload['method'] = empty($workload['method']) ? 'progress' : $workload['method'];
            Logger::info(__CLASS__ . '->' . $workload['method'] . ' got workload.', $workload);
            !($call_result = call_user_func_array([$this, $workload['method']], [$workload['payload'], $log])) && $call_result = [];
            Logger::info('result of the ' . __CLASS__ . '->' . $workload['method'] . '.', $call_result);
        } catch (Exception $e) {
            Logger::emerg('class ' . __CLASS__ . ' throw exception:' . $e->getMessage(), $workload);
        }

        return $call_result;
    }
}