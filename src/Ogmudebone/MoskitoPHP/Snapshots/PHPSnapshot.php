<?php

namespace Ogmudebone\MoskitoPHP\Snapshots;


abstract class PHPSnapshot implements \JsonSerializable
{

    public abstract function getSnapshotId();

}