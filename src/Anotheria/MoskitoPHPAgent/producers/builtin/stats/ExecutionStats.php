<?php

namespace Anotheria\MoskitoPHPAgent\producers\builtin\stats;

use Anotheria\MoskitoPHPAgent\producers\impl\stats\ServiceStats;

class ExecutionStats extends ServiceStats
{

    public function setMemoryUsed($memoryUsed)
    {
        $this->setValue("memoryUsed", $memoryUsed);
    }

}