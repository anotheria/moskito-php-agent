<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;


use Ogmudebone\MoskitoPHP\MoskitoPHP;
use Ogmudebone\MoskitoPHP\producers\builtin\stats\ServiceStat;
use Ogmudebone\MoskitoPHP\producers\MoskitoPHPProducer;

class ServiceOrientedProducer extends MoskitoPHPProducer
{

    public function __construct($producerId, $category, $subsystem)
    {
        parent::__construct($producerId, $category, $subsystem);
        MoskitoPHP::getInstance()->getProducersRepository()->addProducer($this);
    }

    public function getWatcher($statName)
    {

        /**
         * @var ServiceStat $stat
         */
        $stat = $this->addStat(new ServiceStat($statName));

        return new ServiceWatcher($stat);
    }

}