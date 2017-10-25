<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Ogmudebone\MoskitoPHP\producers\MoskitoPHPProducer;

/**
 * Class ExecutionProducer
 * @package Ogmudebone\MoskitoPHP\producers\builtin
 *
 * Builtin producer for monitoring current server request
 * execution time.
 */
class ExecutionProducer extends MoskitoPHPProducer
{

    /**
     * @var PHPExecutionStat
     */
    private $currentRequestStat;
    private $startTime = 0;

    public function __construct(){
        parent::__construct('php-execution', 'php', 'php');
        $this->currentRequestStat = $this->getStat(
            new PHPExecutionStat(
                 $_SERVER['REQUEST_URI']
            )
        );
    }

    public function startCountExecutionTime(){
        $this->startTime = microtime(true);
    }

    public function endCountExecutionTime(){
        $this->currentRequestStat->setTotalTime(
            // PHP has no long, but it can return msec time in float
            // so it possible to count execution time in milliseconds in float and
            // cast it to int as milliseconds
            (int)((microtime(true) - $this->startTime) * 1000)
        );
    }

    public function setError($error){
        $this->currentRequestStat->setError($error);
    }

}