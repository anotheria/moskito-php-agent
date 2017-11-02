<?php

namespace Ogmudebone\MoskitoPHP\producers\builtin;

use Ogmudebone\MoskitoPHP\producers\builtin\stats\ExecutionStats;

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

        $this->requestStats = $this->addStat(
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
        return "phpExecution";
    }

}