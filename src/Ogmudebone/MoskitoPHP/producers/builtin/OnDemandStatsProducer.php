<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Ogmudebone\MoskitoPHP\Mappers;
use Ogmudebone\MoskitoPHP\producers\MoskitoPHPProducer;

class OnDemandStatsProducer extends MoskitoPHPProducer
{

    public function __construct($producerId, $category, $subsystem)
    {
        parent::__construct($producerId, $category, $subsystem);
    }

    protected function getMapperId()
    {
        return  Mappers::ON_DEMAND;
    }

}