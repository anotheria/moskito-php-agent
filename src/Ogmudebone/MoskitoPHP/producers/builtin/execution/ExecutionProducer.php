<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Litipk\BigNumbers\Decimal;
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
        $this->currentRequestStat = $this->addStat(
            new PHPExecutionStat(
                 array_key_exists('REQUEST_URI',$_SERVER)             ?
                     parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) :
                     'Undefined'
            )
        );
    }

    public function startCountExecutionTime(){
        $this->startTime = microtime(true);
    }

    public function endCountExecutionTime(){
        $floatExecTimeSec = Decimal::fromFloat(microtime(true) - $this->startTime);
        $floatExecTimeNano = $floatExecTimeSec->mul(Decimal::fromInteger( 1000 * 1000 * 1000));

        $this->currentRequestStat->setTotalTime(
            (string)$floatExecTimeNano->round()
        );
    }

    public function setError($error){
        $this->currentRequestStat->setError($error);
    }

}