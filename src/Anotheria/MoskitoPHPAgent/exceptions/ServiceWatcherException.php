<?php

namespace Anotheria\MoskitoPHPAgent\exceptions;

use Throwable;

class ServiceWatcherException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}