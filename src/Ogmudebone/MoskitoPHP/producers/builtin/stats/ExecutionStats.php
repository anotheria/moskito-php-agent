<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin\stats;

class ExecutionStats extends ServiceStats
{

    public function setMemoryUsed($memoryUsed)
    {
        $this->setValue("memoryUsed", $memoryUsed);
    }

}