<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Ogmudebone\MoskitoPHP\Mappers;
use Ogmudebone\MoskitoPHP\producers\MoskitoPHPProducer;

class OnDemandStatsProducer extends MoskitoPHPProducer
{

    protected function getMapperId()
    {
        return  Mappers::ON_DEMAND;
    }

}