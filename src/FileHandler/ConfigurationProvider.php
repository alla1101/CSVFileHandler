<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\contracts\FileConfigurationProvider;

use Illuminate\Validation\Validator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

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

	protected function getTranslator(){
		
		$filesystem = new Filesystem();

		$dir=__DIR__.'/../resources/lang';
		$loader = new FileLoader($filesystem,$dir);

		$translator = new Translator($loader, 'en');

		return $translator;
	
	}

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
		
		return $configArray;

	}

	private function validateConfigurations($configArray,$commandName){
		
		if( is_null($configArray) ){

			throw new ConfigurationsException($commandName,"no such command Name exists");
		
		}

		$validationProcess=new Validator($this->getTranslator(),$configArray,$this->validationRules);//app("validator");
		
		// Validation for the configurations are made here
		
		if( $validationProcess->fails() ){
			print_r($validationProcess->errors());
		}

		$validationProcess->validate();

	}

	public function getConfigurationsForCommand(string $commandName){

		$configArray=$this->loadConfigurations($commandName);

		$this->validateConfigurations($configArray,$commandName);

		return $configArray;

	}
	
}