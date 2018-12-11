<?php

namespace a2la1101\csvhandler\Exceptions;

use Exception;

class FileException extends Exception
{

    protected $commandName;

    public function __construct(string $commandName = '',$message = 'something is Wrong with CSV File')
    {
        parent::__construct($message." for Command ".$commandName);

        $this->commandName = $commandName;
    }

    public function commandName()
    {
        return $this->commandName;
    }
    
}