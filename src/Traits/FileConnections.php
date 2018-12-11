<?php

namespace a2la1101\csvhandler\Traits;

use a2la1101\csvhandler\Exceptions\FileException;
use a2la1101\csvhandler\Exceptions\PermissionDeniedException;

trait FileConnections{
	
	public function openConnection()
	{

		$ActualFile = fopen($this->getFileDirectory(), $this->getPermission() );

		if(!$ActualFile){
			throw new FileException();
		}

		return $ActualFile;

	}

	public function closeConnection($ActualFile)
	{

		fclose($ActualFile);

	}

	public function isFile()
	{

		return file_exists( $this->getFileDirectory() );
	
	}

	public function isReadable()
	{

		return is_readable( $this->getFileDirectory() );
	
	}

	public function isWritable()
	{

		return is_writable( $this->getFileDirectory() );
	
	}
	
}