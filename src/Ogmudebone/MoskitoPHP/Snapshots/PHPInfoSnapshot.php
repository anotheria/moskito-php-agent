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

    public function getProducerId()
    {
        return 'php-info';
    }

    public function getValues()
    {
        return [
            'phpVersion' => $this->phpVersion,
            'hostname' => $this->hostName,
        ];
    }

}