<?php

namespace Anotheria\MoskitoPHPAgent\producers\builtin;

use Litipk\BigNumbers\Decimal;
use Anotheria\MoskitoPHPAgent\exceptions\ServiceWatcherException;
use Anotheria\MoskitoPHPAgent\producers\builtin\stats\ServiceStats;

class ServiceWatcher
{

    const STATE_NONE = 'none';
    const STATE_STARTED = 'started';
    const STATE_FINISHED = 'finished';

    private $stat;
    private $state = ServiceWatcher::STATE_NONE;
    private $startTime;

    public function __construct(ServiceStats $stat)
    {
        $this->stat = $stat;
    }

    public function start()
    {

        if($this->state != ServiceWatcher::STATE_NONE)
            throw new ServiceWatcherException(
                'Service already ' .
                $this->state == ServiceWatcher::STATE_STARTED ? 'started' : 'finished'
            );

        $this->state = ServiceWatcher::STATE_STARTED;
        $this->startTime = microtime(true);

    }

    public function end($hasError = false)
    {

        if($this->state != ServiceWatcher::STATE_STARTED)
            throw new ServiceWatcherException(
                $this->state == ServiceWatcher::STATE_STARTED
                    ? 'Service not started'
                    : 'Service already finished'
            );

        $this->state = ServiceWatcher::STATE_FINISHED;

        $floatExecTimeSec = Decimal::fromFloat(microtime(true) - $this->startTime);
        $floatExecTimeNano = $floatExecTimeSec->mul(Decimal::fromInteger( 1000 * 1000 * 1000));
        $integerExecTimeNano = (string)$floatExecTimeNano->round();

        $this->stat->setTotalTime($integerExecTimeNano);
        $this->stat->setError($hasError);

    }

}