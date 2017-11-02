<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Ogmudebone\MoskitoPHP\MoskitoPHP;
use Ogmudebone\MoskitoPHP\producers\builtin\stats\ServiceStats;
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
         * @var ServiceStats $stat
         */
        $stat = $this->addStat(new ServiceStats($statName));

        return new ServiceWatcher($stat);

    }

    protected function getMapperId()
    {
        return "service";
    }

}