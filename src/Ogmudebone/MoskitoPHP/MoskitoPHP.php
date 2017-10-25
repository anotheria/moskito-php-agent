<?php

namespace Ogmudebone\MoskitoPHP;

use Ogmudebone\MoskitoPHP\producers\builtin\ExecutionProducer;
use Ogmudebone\MoskitoPHP\producers\ProducersRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class MoskitoPHP
{

    /**
     * @var MoskitoPHP $instance
     */
    private static $instance;

    private $producersRepository;
    /**
     * @var ExecutionProducer $executionProducer
     */
    private $executionProducer;

    public static function init(){

        MoskitoPHP::$instance = new MoskitoPHP();
        $instance = MoskitoPHP::$instance;

        register_shutdown_function(function() use ($instance) {
            $instance->executionProducer->endCountExecutionTime();
            $instance->sendSnapshots();
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
echo $config->getRabbitmqQueueName();
        $channel->queue_declare($config->getRabbitmqQueueName(),
            false, false, false, false
        );

        foreach ($this->producersRepository->getProducers() as $producer) {

            $message = new AMQPMessage(json_encode($producer));
            $channel->batch_basic_publish(
                $message,
                '',
                $config->getRabbitmqQueueName()
                );

        }

        $channel->publish_batch();
        $channel->close();
        $connection->close();

    }

    private function __construct()
    {
        $this->producersRepository = new ProducersRepository();
        $this->executionProducer = $this->producersRepository->addProducer(
            new ExecutionProducer()
        );
        $this->executionProducer->startCountExecutionTime();
    }

    /**
     * @return MoskitoPHP
     */
    public static function getInstance()
    {
        return self::$instance;
    }

}