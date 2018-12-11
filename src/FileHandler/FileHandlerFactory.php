<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\FileHandler\FileReader;
use a2la1101\csvhandler\FileHandler\FileWriter;

use a2la1101\csvhandler\contracts\ReadOnlyFileHandler;
use a2la1101\csvhandler\contracts\WriteOnlyFileHandler;
use a2la1101\csvhandler\contracts\PermissionDeniedException;
use a2la1101\csvhandler\contracts\FileConfigurationProvider;
class FileHandlerFactory{

	protected $configurationProvider;
	
	Public function setConfigurationProvider(FileConfigurationProvider $configProvider)
	{

		$this->configurationProvider=$configProvider;
	}

	public function createFileHandler($commandName)
	{

		$configArray=$this->configurationProvider->getConfigurationsForCommand($commandName);

		$fileObject=$this->getFileHandlerBasedOnPermission($configArray["Permission"]);

		$fileObject=$this->setConfigurations($configArray,$fileObject);

		$newFileObject=$this->convertToInterface($fileObject,$configArray["Permission"]);

		return $newFileObject;

	}

	private function getFileHandlerBasedOnPermission($permission){
		
		switch ($permission) {
			case 'r':
				$fileObject=new FileReader();
				break;
			case 'w':
				$fileObject=new FileWriter();
				break;
		}

		return $fileObject;
	}

	private function convertToInterface($fileObject,$permission){

		switch ($permission) {
			case 'r':
				$newObject=$this->convertInterfacetoReadOnly($fileObject);
				break;
			case 'w':
				$newObject=$this->convertInterfacetoWriteOnly($fileObject);
				break;
		}

		return $newObject;
	}

	private function convertInterfacetoWriteOnly(WriteOnlyFileHandler $FileObject){

		return $FileObject;

	}

	private function convertInterfacetoReadOnly(ReadOnlyFileHandler $FileObject){

		return $FileObject;
	
	}

	private function setConfigurations($configArray,$FileObject)
	{
		
		$FileObject->setFileDirectory($configArray["Directory"]);
		$FileObject->setFormat($configArray["Format"]);
		$FileObject->setDelimiter($configArray["Delimiter"]);

		return $FileObject;
	
	}

}