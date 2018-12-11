<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\contracts\FileConfigurationProvider;

use Illuminate\Validation\Factory;
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

	protected function getValidator(){
		
		// Create a Filesystem instance
		$filesystem = new Filesystem();

		// Create a new FileLoader instance specifying the translation path
		$loader = new FileLoader($filesystem, dirname(dirname(__FILE__)) . '/lang');

		// Specify the translation namespace
		$loader->addNamespace('lang', dirname(dirname(__FILE__)) . '/lang');

		// This is used to create the path to your validation.php file
		$loader->load($lang = 'en', $group = 'validation', $namespace = 'lang');

		$factory = new Translator($loader, 'en');

		$validator=new Factory($factory);

		return $validator;
	
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
		
		//$configArray=Container::getInstance()->make("config")->get($configuration);
	
		return $configArray;

	}

	private function validateConfigurations($configArray,$commandName){
		
		if( is_null($configArray) ){

			throw new ConfigurationsException($commandName,"no such command Name exists");
		
		}

		$validator=$this->getValidator();//app("validator");
		
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