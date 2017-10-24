<?php

namespace Ogmudebone\MoskitoPHP\Snapshots;


abstract class PHPSnapshot implements \JsonSerializable
{

    public abstract function getProducerId();

    public function jsonSerialize()
    {
        $array = get_object_vars($this);

        unset($array['_parent'], $array['_index']);

        array_walk_recursive($array, function (&$property) {
            if (is_object($property) && method_exists($property, 'toArray')) {
                $property = $property->toArray();
            }
        });

        return array_merge($array, ['producerId' => $this->getProducerId()]);
    }

}