<?php

namespace Ogmudebone\MoskitoPHP;

use JsonSerializable;

class AppData implements JsonSerializable
{

    private $memoryUsage;
    private $peakMemoryUsage;
    //private $systemLoad;
    private $hostName;

    private $executionStartTime;
    private $executionEndTime;

    /**
     * @var AppData
     */
    private static $instance;

    public static function initAppDataCollection(){

        AppData::$instance =  new AppData();
        $instance = AppData::$instance;

        $instance->hostName = gethostname();
        $instance->executionStartTime = microtime();

        register_shutdown_function(
            function() use ($instance) {
                $instance->executionEndTime = microtime();
                $instance->memoryUsage = memory_get_usage();
                $instance->peakMemoryUsage = memory_get_peak_usage();
                $instance->save();
            }
        );

    }

    private function save(){
        file_put_contents("app-data.json", json_encode($this));
    }

    public function jsonSerialize()
    {
        return [
            "host" => $this->hostName,
            "mem_usage" => $this->memoryUsage,
            "peak_mem_usage" => $this->peakMemoryUsage,
            "exec_start_time" => $this->executionStartTime,
            "exec_end_time" => $this->executionEndTime
        ];
    }
}
