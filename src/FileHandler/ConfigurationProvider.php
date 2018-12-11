<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\contracts\FileConfigurationProvider;

use Illuminate\Validation\Validator;
use a2la1101\csvhandler\Exceptions\ConfigurationsException;

class ConfigurationProvider implements FileConfigurationProvider{

	protected $validationRules=
	[
		"Directory"=>"required|regex:/^(\/[a-z_\-\s0-9\.]+)+(\/[a-z_\-\s0-9\.]+)\.csv$/",
		"Delimiter"=>"required|min:1|max:255",
		"Format"=>"required|min:1",
		"Permission"=>"required|regex:/^[(r)(w)]$/"
	];

	private function loadConfigurations(string $commandName){

		$configuration="CSVHandler.".$commandName;

		$configArray=config($configuration);
	
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