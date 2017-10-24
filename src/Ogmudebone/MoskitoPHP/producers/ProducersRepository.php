<?php
/**
 * Created by PhpStorm.
 * User: submi
 * Date: 10/24/2017
 * Time: 5:23 PM
 */

namespace Ogmudebone\MoskitoPHP\producers;

/**
 * Class ProducersRepository
 * @package Ogmudebone\MoskitoPHP\producers
 * Stores producers.
 * Used in MoskitoPHP singleton for storing producers
 */
class ProducersRepository
{

    /** @var MoskitoPHPProducer[] $producers */
    private $producers = [];

    /**
     * @param string $name producer name
     * @return MoskitoPHPProducer|null
     */
    public function getProducer($name){
        return $this->producers[$name];
    }

    public function addProducer(MoskitoPHPProducer $producer){
        $this->producers[] = $producer;
        return $producer;
    }

    /**
     * @return MoskitoPHPProducer[]
     */
    public function getProducers()
    {
        return $this->producers;
    }

    /**
     * @param array $producers
     */
    public function setProducers($producers)
    {
        $this->producers = $producers;
    }

}