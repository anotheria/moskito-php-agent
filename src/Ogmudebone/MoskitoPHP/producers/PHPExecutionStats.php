<?php
/**
 * Created by PhpStorm.
 * User: submi
 * Date: 10/24/2017
 * Time: 5:36 PM
 */

namespace Ogmudebone\MoskitoPHP\producers;

/**
 * Class PHPExecutionStats
 * @package Ogmudebone\MoskitoPHP\producers
 *
 * Statistics for single server request.
 * Currently contains only execution time and error statistics.
 */
class PHPExecutionStats extends Stat
{

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setError(false);
    }

    public function setTotalTime($time){
        $this->setValue('time', $time);
    }

    public function setError($error){
        $this->setValue('error', $error);
    }

}