<?php

namespace a2la1101\csvhandler\Exceptions;

use Exception;

class PermissionDeniedException extends Exception
{

    protected $commandName;

    public function __construct(string $commandName = '',$message = '(Read or Write) permission denied for file in command')
    {
        parent::__construct($message." ".$commandName);

        $this->commandName = $commandName;
    }

    public function permission()
    {
        return $this->commandName;
    }
}