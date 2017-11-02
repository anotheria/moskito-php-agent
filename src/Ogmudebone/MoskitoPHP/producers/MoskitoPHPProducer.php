<?php

namespace Ogmudebone\MoskitoPHP\producers;

/**
 * Class MoskitoPHPProducer
 * @package Ogmudebone\MoskitoPHP\producers
 *
 * Stats producer class for recording statistics from PHP
 */
abstract class MoskitoPHPProducer implements \JsonSerializable
{

    private $producerId;
    private $category;
    private $subsystem;

    /** @var Stats[] $stats */
    private $stats = [];

    protected function __construct($producerId, $category, $subsystem)
    {
        $this->producerId = $producerId;
        $this->category = $category;
        $this->subsystem = $subsystem;
    }

    /**
     * @param Stats $stat
     * @return Stats
     */
    protected function addStat(Stats $stat)
    {
        $this->stats[$stat->getName()] = $stat;
        return $stat;
    }

    protected function getStat($name)
    {

        if(!array_key_exists($name, $this->stats))
            return null;
        else
            return $this->stats[$name];

    }

    public function jsonSerialize()
    {

        $statsSerialized = [];

        foreach ($this->stats as $stat)
            $statsSerialized[] = $stat->jsonSerialize();

        return [
            'producerId' => $this->producerId,
            'category'   => $this->category,
            'subsystem'  => $this->subsystem,
            'mapperId'   => $this->getMapperId(),
            'stats'      => $statsSerialized
        ];
    }

    /**
     * @return mixed
     */
    public function getProducerId()
    {
        return $this->producerId;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getSubsystem()
    {
        return $this->subsystem;
    }

    protected abstract function getMapperId();

}