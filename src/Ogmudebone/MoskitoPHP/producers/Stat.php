<?php

namespace Ogmudebone\MoskitoPHP\producers;

/**
 * Class Stat
 * @package Ogmudebone\MoskitoPHP\producers
 *
 * Producer stat class
 */
class Stat implements \JsonSerializable
{

    /**
     * @var array $values current stat values
     */
    private $values = [];
    /**
     * @var string $name stat name
     */
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setValue($name, $value){
        $this->values[$name] = $value;
    }

    public function getValue($name){
        return $this->values[$name];
    }

    public function getName(){
        return $this->name;
    }

    /**
     * return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'values' => $this->values
        ];
    }

}