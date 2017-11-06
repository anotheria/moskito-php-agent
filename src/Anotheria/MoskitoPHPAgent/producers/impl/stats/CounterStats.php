<?php

namespace Anotheria\MoskitoPHPAgent\producers\impl\stats;

use Anotheria\MoskitoPHPAgent\producers\Stats;

class CounterStats extends Stats
{

    public function __construct($name)
    {
        parent::__construct($name);
        $this->setValue('inc', 0);
    }

    public function inc($by = 1)
    {
        $this->setValue('inc',
            $this->getValue('inc') + $by
            );
    }

}