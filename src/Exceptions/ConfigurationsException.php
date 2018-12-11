<?php

namespace a2la1101\csvhandler\Exceptions;

use Exception;

class ConfigurationsException extends Exception
{

    protected $commandName;

    public function __construct(string $commandName = '',$message = 'something wrong with Configurations')
    {
        parent::__construct($message." for Command ".$commandName);

        $this->commandName = $commandName;
    }

    public function commandName()
    {
        return $this->commandName;
    }
}