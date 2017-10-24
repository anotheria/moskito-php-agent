<?php

namespace Ogmudebone\MoskitoPHP;

use JsonSerializable;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class AppData implements JsonSerializable
{

    const PATH_TO_ROOT = __DIR__ . "../../../../../../../";

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

        $connection = new AMQPStreamConnection('localhost', 5672, 'test', 'test');
        $channel = $connection->channel();
        $message = new AMQPMessage(json_encode($this));
        $channel->basic_publish($message);

        $channel->close();
        $connection->close();

       // file_put_contents(AppData::PATH_TO_ROOT . "app-data.json", json_encode($this));
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
