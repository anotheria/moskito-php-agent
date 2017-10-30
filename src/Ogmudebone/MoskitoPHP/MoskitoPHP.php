<?php

namespace Ogmudebone\MoskitoPHP;

use Ogmudebone\MoskitoPHP\producers\builtin\BuiltinInitializer;
use Ogmudebone\MoskitoPHP\producers\ProducersRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class MoskitoPHP
 * @package Ogmudebone\MoskitoPHP
 */
class MoskitoPHP
{

    /**
     * @var MoskitoPHP $instance
     */
    private static $instance;

    private $producersRepository;

    private function sendSnapshots()
    {

        $config = MoskitoPHPConfig::getInstance();

        $connection = new AMQPStreamConnection(
            $config->getRabbitmqHost(),
            $config->getRabbitmqPort(),
            $config->getRabbitmqLogin(),
            $config->getRabbitmqPassword()
        );

        $channel = $connection->channel();
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
        BuiltinInitializer::initialize();
        $instance = $this;
        register_shutdown_function(function () use ($instance) {
            $instance->sendSnapshots();
        });
    }

    /**
     * @return MoskitoPHP
     */
    public static function getInstance()
    {

        if(MoskitoPHP::$instance != null) {
            MoskitoPHP::$instance = new MoskitoPHP();
        }

        return self::$instance;

    }

    /**
     * @return ProducersRepository
     */
    public function getProducersRepository()
    {
        return $this->producersRepository;
    }

}