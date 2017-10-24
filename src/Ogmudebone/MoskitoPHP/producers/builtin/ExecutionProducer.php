<?php
/**
 * Created by PhpStorm.
 * User: submi
 * Date: 10/24/2017
 * Time: 5:23 PM
 */

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
     * @var \Ogmudebone\MoskitoPHP\producers\PHPExecutionStats
     */
    private $currentRequestStat;
    private $startTime = 0;

    public function __construct(){
        parent::__construct('php-execution', 'php', 'php');
        $this->currentRequestStat = $this->addStat($_SERVER['REQUEST_URI']);
    }

    public function startCountExecutionTime(){
        $this->startTime = microtime(true);
    }

    public function endCountExecutionTime(){
        $this->currentRequestStat->setTotalTime($this->startTime - microtime(true));
    }

    public function setError($error){
        $this->currentRequestStat->setError($error);
    }

}