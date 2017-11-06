<?php

namespace Anotheria\MoskitoPHPAgent\producers\builtin;
use Anotheria\MoskitoPHPAgent\producers\builtin\stats\ExecutionStats;
use Anotheria\MoskitoPHPAgent\producers\impl\ServiceOrientedProducer;
use Anotheria\MoskitoPHPAgent\producers\impl\ServiceWatcher;
use Anotheria\MoskitoPHPAgent\producers\impl\stats\ServiceStats;


/**
 * Class ExecutionProducer
 * @package Ogmudebone\MoskitoPHP\producers\builtin
 *
 * Builtin producer for monitoring current server request
 * execution time and memory usage.
 */
class ExecutionProducer extends ServiceOrientedProducer
{

    /**
     * @var ExecutionStats $requestStats
     */
    private $requestStats;

    public function __construct()
    {
        parent::__construct('php-execution', 'php', 'php');

        $currentURI = array_key_exists('REQUEST_URI', $_SERVER)
            ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            : 'Undefined';

        $this->requestStats = $this->addStats(
            new ExecutionStats($currentURI)
        );

    }

    public function getExecutionWatcher()
    {
        return new ServiceWatcher($this->requestStats);
    }

    public function updateMemoryUsage()
    {
        $this->requestStats->setMemoryUsed(memory_get_peak_usage(true));
    }

    protected function getMapperId()
    {
        return "ExecutionStatsMapper";
    }

}