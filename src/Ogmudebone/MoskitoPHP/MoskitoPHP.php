<?php

namespace Ogmudebone\MoskitoPHP;

use Ogmudebone\MoskitoPHP\Snapshots\PHPExecutionSnapshot;
use Ogmudebone\MoskitoPHP\Snapshots\PHPInfoSnapshot;
use Ogmudebone\MoskitoPHP\Snapshots\PHPSnapshot;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MoskitoPHP
{

    /**
     * @var PHPSnapshot[] $snapshots
     */
    private $snapshots = [];

    /**
     * @var MoskitoPHP $instance
     */
    private static $instance;

    public static function init(){

        MoskitoPHP::$instance = new MoskitoPHP();
        $instance = MoskitoPHP::$instance;

        register_shutdown_function(function() use ($instance) {
            $instance->sendSnapshots();
        });

    }

    private function addSnapshot(PHPSnapshot $snapshot){
        $this->snapshots[] = $snapshot;
    }

    private function collectPHPInfoSnapshot(){

        $infoSnapshot = new PHPInfoSnapshot();

        $infoSnapshot->setHostName(gethostname());
        $infoSnapshot->setPhpVersion(phpversion());
        $infoSnapshot->setCreatedAt(time());

        $this->addSnapshot($infoSnapshot);

    }

    private function collectPHPExecutionSnapshot(){

        $startExecutionTime = time();
        $_this = $this;

        register_shutdown_function(function() use ($startExecutionTime, $_this) {

            $executionSnapshot = new PHPExecutionSnapshot();

            $executionSnapshot->setExecutionStartTime($startExecutionTime);
            $executionSnapshot->setExecutionEndTime(time());
            $executionSnapshot->setMemoryUsage(memory_get_usage());
            $executionSnapshot->setPeakMemoryUsage(memory_get_peak_usage());
            $executionSnapshot->setRequestUri($_SERVER['REQUEST_URI']);

            $_this->addSnapshot($executionSnapshot);

        });

    }

    private function sendSnapshots(){

        $config = MoskitoPHPConfig::getInstance();

        $connection = new AMQPStreamConnection(
            $config->getRabbitmqHost(),
            $config->getRabbitmqPort(),
            $config->getRabbitmqLogin(),
            $config->getRabbitmqPassword()
        );

        $channel = $connection->channel();

        $channel->exchange_declare(
            $config->getRabbitmqTopicName(), 'topic', false, false, false
        );

        foreach ($this->snapshots as $snapshot) {

            $message = new AMQPMessage(json_encode($snapshot));
            $channel->batch_basic_publish(
                $message,
                $config->getRabbitmqTopicName(),
                'moskito.' . $snapshot->getSnapshotId()
                );

        }

        $channel->publish_batch();
        $channel->close();
        $connection->close();

    }

    private function __construct()
    {
        $this->collectPHPInfoSnapshot();
        $this->collectPHPExecutionSnapshot();
    }

}