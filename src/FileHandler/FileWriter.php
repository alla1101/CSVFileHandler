<?php

namespace a2la1101\csvhandler\FileHandler;


use a2la1101\csvhandler\Traits\FileConnections;
use a2la1101\csvhandler\contracts\GeneralFileHandler;
use a2la1101\csvhandler\contracts\WriteOnlyFileHandler;

use a2la1101\csvhandler\Exceptions\FileException;
use a2la1101\csvhandler\Exceptions\PermissionDeniedException;

class FileWriter implements WriteOnlyFileHandler,GeneralFileHandler {
	
	use FileConnections;

	protected $Directory;

	protected $Format;

	protected $ReadOrWritePermission;

	protected $Delimiter;

	protected $Act_File;

	public function __construct(){

		$this->ReadOrWritePermission="w";
	
	}

	public function getDelimiter()
	{

		return $this->Delimiter;

	}

	public function setDelimiter(string $delimiter)
	{

		$this->Delimiter=$delimiter;

	}

	public function getFileDirectory()
	{

		return $this->Directory;

	}

	public function setFileDirectory(String $directory)
	{

		$this->Directory = $directory;

	}

	public function getPermission()
	{

		return $this->ReadOrWritePermission;

	}

	public function setFormat(string $format)
	{

		$this->Format=$format;

	}

	public function getFormat()
	{

		return $this->Format;

	}

	private function openFile()
	{

		if( !$this->isWritable() )
		{

			//throw new PermissionDeniedException("Permission to write is denied","w");
		}

		$this->Act_File = $this->openConnection();

	}

	private function isOpen()
	{
		
		return !is_null($this->Act_File);
	
	}

	private function closeFile()
	{

		$this->closeConnection($this->Act_File);

		$this->Act_File=null;
	
	}

	public function writeAll($AllLinesData){

		if(! $this->isOpen() )
		{

			$this->openFile();
		
		}
		
		$keys=$this->getKeys();
		
		foreach ($AllLinesData as $OneLineData) {

			$this->writeline($OneLineData,$keys);
		
		}
		
		$this->closeFile();

	}

	public function writeByLine($OneLineData,$keys=null){

		if(! $this->isOpen() )
		{

			$this->openFile();
		
		}

		if(is_null($OneLineData))
		{
			$this->closeFile();
			return;
		}
		
		$this->Writeline($OneLineData,$keys);

	}

	private function writeline($OneLineData,$keys=null)
	{
		if(is_null($keys))
		{
			$key=$this->getKeys();
		}

		$line=$this->convertDataToLine($OneLineData,$keys);

		if(!$this->writeToFile($line))
		{
			throw new FileException('',"Can't Write Line to file");
		}

	}

	private function convertDataToLine($dataArray,$keys)
	{
		$line="";

		foreach ($keys as $key) {

			$line.=$dataArray[$key].$this->getDelimiter();
		
		}

		$line=substr($line, 0, -1)."\n";

		return $line;
	}

	private function writeToFile($line)
	{
		return fwrite($this->Act_File, $line); 
	}

	private function getKeys()
	{

		return explode($this->getDelimiter(), $this->getFormat() );
	}

	
}