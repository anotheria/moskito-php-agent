<?php

namespace Ogmudebone\MoskitoPHP\Snapshots;

/**
 * @TODO : RENAME CLASS TO NOT CONFUSE WITH phpinfo()
 * Class PHPInfoSnapshot
 * @package Ogmudebone\MoskitoPHP
 */
class PHPInfoSnapshot extends PHPSnapshot
{

    private $phpVersion;
    private $hostName;
    private $createdAt;

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'phpVersion' => $this->phpVersion,
            'hostName'   => $this->hostName,
            'createdAt'  => $this->createdAt
        ];
    }

    /**
     * @param mixed $phpVersion
     */
    public function setPhpVersion($phpVersion)
    {
        $this->phpVersion = $phpVersion;
    }

    /**
     * @param mixed $hostName
     */
    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getSnapshotId()
    {
        return 'info';
    }
}