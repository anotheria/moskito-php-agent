<?php

namespace Anotheria\MoskitoPHPAgent\producers\impl;

use Anotheria\MoskitoPHPAgent\producers\impl\stats\CounterStats;
use Anotheria\MoskitoPHPAgent\producers\MoskitoPHPProducer;

class CounterProducer extends MoskitoPHPProducer
{

    public function __construct($producerId, $category, $subsystem)
    {
        parent::__construct($producerId, $category, $subsystem);
    }

    protected function getMapperId()
    {
        return 'CounterStatsMapper';
    }

    public function incStats($name, $by)
    {

        if($this->getStats($name) == null)
        {
            $this->addStats(new CounterStats($name));
        }

        /**
         * @var CounterStats $counterStats
         */
        $counterStats = $this->getStats($name);

        $counterStats->inc($by);

    }

}