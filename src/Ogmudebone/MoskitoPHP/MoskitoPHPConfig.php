<?php

namespace Ogmudebone\MoskitoPHP;

/**
 * Class MoskitoPHPConfig
 * @package Ogmudebone\MoskitoPHP
 *
 * Configuration file for moskito php
 *
 * Gets configuration from file named "moskito-php-config.json" in application root
 * This package contains example of configuration file named "moskito-php-config.json.example".
 *
 */
class MoskitoPHPConfig
{

    const PATH_TO_ROOT = __DIR__ . "../../../../../../../";

    /**
     * @var MoskitoPHPConfig $instance
     */
    private static $instance;

    /**
     * @var string $rabbitmqHost hostname of RabbitMQ server to send data from PHP
     */
    private $rabbitmqHost;
    /**
     * @var string $rabbitmqPort port of RabbitMQ server to send data from PHP
     */
    private $rabbitmqPort;
    /**
     * @var string $rabbitmqPort login for RabbitMQ
     */
    private $rabbitmqLogin;
    /**
     * @var string $rabbitmqPort password for RabbitMQ
     */
    private $rabbitmqPassword;
    /**
     * @var string $rabbitmqPort name of queue where php snapshots placed
     */
    private $rabbitmqTopicName;

    private function __construct()
    {

        $configJson = json_decode(
            file_get_contents(MoskitoPHPConfig::PATH_TO_ROOT . 'moskito-php-config.json'),
            true
        );

        $this->rabbitmqHost      =  $configJson['rabbitmq-host'];
        $this->rabbitmqPort      =  $configJson['rabbitmq-port'];
        $this->rabbitmqLogin     =  $configJson['rabbitmq-login'];
        $this->rabbitmqPassword  =  $configJson['rabbitmq-password'];
        $this->rabbitmqTopicName =  $configJson['rabbitmq-topic-name'];

    }

    /**
     * @return MoskitoPHPConfig
     */
    public static function getInstance(){

        if(MoskitoPHPConfig::$instance == null){
            MoskitoPHPConfig::$instance = new MoskitoPHPConfig();
        }

        return MoskitoPHPConfig::$instance;

    }

    /**
     * @return mixed
     */
    public function getRabbitmqTopicName()
    {
        return $this->rabbitmqTopicName;
    }

    /**
     * @return mixed
     */
    public function getRabbitmqPassword()
    {
        return $this->rabbitmqPassword;
    }

    /**
     * @return mixed
     */
    public function getRabbitmqHost()
    {
        return $this->rabbitmqHost;
    }

    /**
     * @return mixed
     */
    public function getRabbitmqPort()
    {
        return $this->rabbitmqPort;
    }

    /**
     * @return mixed
     */
    public function getRabbitmqLogin()
    {
        return $this->rabbitmqLogin;
    }

}