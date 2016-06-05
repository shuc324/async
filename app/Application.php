<?php
/**
 * this source file is Application.php
 *
 * author: shuc <shuc324@gmail.com>
 * time:   2016-05-31 11-26
 */
namespace App;

use Dotenv\Dotenv;
use Exception;
use GearmanPeclManager;
use Noodlehaus\Config;
use Noodlehaus\AbstractConfig;
use App\Utils\Config as AppConfig;

class Container extends AbstractConfig
{
    public function __construct()
    {
        parent::__construct([]);
    }
}

class Application
{
    public $config;

    public function __construct()
    {
        try {
            (new Dotenv('./app'))->load();
        } catch (Exception $e) {

        }
        AppConfig::init($this->configure());
    }

    public function run()
    {
        declare(ticks = 1);

        (new GearmanPeclManager())->run();
    }

    public function configure()
    {
        $this->config = new Container();
        $config_files = glob(__DIR__ . "/Config/*.php");
        foreach ($config_files as $config_file) {
            if (!$this->config->has($config_file)) {
                $this->config->set(mb_substr(basename($config_file), 0, -4), (new Config($config_file))->all());
            }
        }
        return $this->config;
    }
}