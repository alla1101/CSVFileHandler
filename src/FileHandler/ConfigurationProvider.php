<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\contracts\FileConfigurationProvider;

use Illuminate\Validation\Validator;
use Illuminate\Container\Container;

use a2la1101\csvhandler\Exceptions\ConfigurationsException;

class ConfigurationProvider implements FileConfigurationProvider{

	protected $configurationsDirectory=null;

	protected $validationRules=
	[
		"Directory"=>"required|regex:/^(\/[a-z_\-\s0-9\.]+)+(\/[a-z_\-\s0-9\.]+)\.csv$/",
		"Delimiter"=>"required|min:1|max:255",
		"Format"=>"required|min:1",
		"Permission"=>"required|regex:/^[(r)(w)]$/"
	];

	public function setConfigurationsDirectory($directory){
		
		$this->configurationsDirectory=$directory;
	
	}

	private function loadConfigurations(string $commandName){

		if(is_null($this->configurationsDirectory))
		{
			$configuration="CSVHandler.".$commandName;
			$configArray=app("config")->get($configuration);
		}
		else
		{
			$configs=include($this->configurationsDirectory);

			$configArray=null;

			if(isset( $configs[$commandName] ) )
			{
				$configArray=$configs[$commandName];
			}
		}
		
		//$configArray=Container::getInstance()->make("config")->get($configuration);
	
		return $configArray;

	}

	private function validateConfigurations($configArray,$commandName){
		
		if( is_null($configArray) ){

			throw new ConfigurationsException($commandName,"no such command Name exists");
		
		}

		$validator=app("validator");
		
		// Validation for the configurations are made here
		
		$validationProcess=$validator->make($configArray,$this->validationRules);

		if( $validationProcess->fails() ){
			print_r($x->errors());
		}

		$validationProcess->validate();

	}

	public function getConfigurationsForCommand(string $commandName){

		$configArray=$this->loadConfigurations($commandName);

		$this->validateConfigurations($configArray,$commandName);

		return $configArray;

	}
	
}