<?php

namespace Ogmudebone\MoskitoPHP\Snapshots;


abstract class PHPSnapshot implements \JsonSerializable
{

    public abstract function getProducerId();
    public abstract function getValues();

    public function jsonSerialize()
    {
        return array_merge($this->getValues(),
            ['producerId' => $this->getProducerId()]
        );
    }

}