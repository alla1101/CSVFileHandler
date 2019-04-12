<?php

namespace a2la1101\csvhandler\contracts;

interface FileConfigurationProvider{
	
	public function getConfigurationsForCommand(string $commandName);
	
}