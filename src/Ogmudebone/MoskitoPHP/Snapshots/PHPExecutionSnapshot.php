<?php

namespace Ogmudebone\MoskitoPHP\Snapshots;


class PHPExecutionSnapshot extends PHPSnapshot
{

    private $executionStartTime;
    private $executionEndTime;
    private $memoryUsage;
    private $peakMemoryUsage;
    private $requestUri;

    /**
     * @inheritdoc
     * return array
     */
    public function jsonSerialize()
    {
        return [
            "memoryUsage"        => $this->memoryUsage,
            "requestPath"        => $this->requestUri,
            "peakMemoryUsage"    => $this->peakMemoryUsage,
            "executionStartTime" => $this->executionStartTime,
            "executionEndTime"   => $this->executionEndTime
        ];
    }

    /**
     * @param mixed $executionStartTime
     */
    public function setExecutionStartTime($executionStartTime)
    {
        $this->executionStartTime = $executionStartTime;
    }

    /**
     * @param mixed $executionEndTime
     */
    public function setExecutionEndTime($executionEndTime)
    {
        $this->executionEndTime = $executionEndTime;
    }

    /**
     * @param mixed $memoryUsage
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = $memoryUsage;
    }

    /**
     * @param mixed $peakMemoryUsage
     */
    public function setPeakMemoryUsage($peakMemoryUsage)
    {
        $this->peakMemoryUsage = $peakMemoryUsage;
    }

    /**
     * @param mixed $requestUri
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = $requestUri;
    }

}