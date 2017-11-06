<?php

namespace Anotheria\MoskitoPHPAgent;

use Anotheria\MoskitoPHPAgent\producers\builtin\BuiltinInitializer;
use Anotheria\MoskitoPHPAgent\producers\ProducersRepository;
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

    /**
     * @var ProducersRepository $producersRepository
     */
    private $producersRepository;

    /**
     * @var MoskitoPHPConfig $config
     */
    private $config;

    private function sendSnapshots()
    {

        $connection = new AMQPStreamConnection(
            $this->config->getRabbitmqHost(),
            $this->config->getRabbitmqPort(),
            $this->config->getRabbitmqLogin(),
            $this->config->getRabbitmqPassword()
        );

        $channel = $connection->channel();
        $channel->queue_declare($this->config->getRabbitmqQueueName(),
            false, false, false, false
        );

        foreach ($this->producersRepository->getProducers() as $producer) {

            $message = new AMQPMessage(json_encode($producer));
            $channel->batch_basic_publish(
                $message,
                '',
                $this->config->getRabbitmqQueueName()
                );

        }

        $channel->publish_batch();
        $channel->close();
        $connection->close();

    }

    private function __construct()
    {
        $this->config = MoskitoPHPConfig::getInstance();
        $this->producersRepository = new ProducersRepository();
    }

    /**
     * @return MoskitoPHP
     */
    public static function getInstance()
    {

        if(MoskitoPHP::$instance == null) {

            MoskitoPHP::$instance = new MoskitoPHP();

            $instance = MoskitoPHP::$instance;
            BuiltinInitializer::initialize($instance->config);

            register_shutdown_function(function () use ($instance) {
                $instance->sendSnapshots();
            });

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