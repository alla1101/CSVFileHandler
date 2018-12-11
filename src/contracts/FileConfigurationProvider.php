<?php

namespace a2la1101\csvhandler\Contracts;

interface FileConfigurationProvider{
	
	public function getConfigurationsForCommand(string $commandName);
	
}