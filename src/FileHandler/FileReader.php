<?php

namespace a2la1101\csvhandler\FileHandler;

use a2la1101\csvhandler\contracts\ReadOnlyFileHandler;
use a2la1101\csvhandler\Traits\FileConnections;
use a2la1101\csvhandler\contracts\GeneralFileHandler;

use a2la1101\csvhandler\Exceptions\PermissionDeniedException;
use a2la1101\csvhandler\Exceptions\FileException;

class FileReader implements ReadOnlyFileHandler,GeneralFileHandler {
	
	use FileConnections;

	protected $Directory;

	protected $Format;

	protected $ReadOrWritePermission;

	protected $Delimiter;

	protected $Act_File;

	public function __construct(){

		$this->ReadOrWritePermission="r";
	
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

	private function openFile(){

		if( !$this->isFile() ){

			throw new FileException("","File doesn't exist in directory or wrong directory");

		}

		if( !$this->isReadable() ){

			throw new PermissionDeniedException("Permission to read is denied","r");
		}

		$this->Act_File = $this->openConnection();

	}

	private function isOpen(){
		return !is_null($this->Act_File);
	}

	private function closeFile()
	{

		$this->closeConnection($this->Act_File);

		$this->Act_File=null;
	
	}

	public function readAll(){

		$Result=[];
		
		// Get Keys of Data from Format
		$keys=$this->getKeys();

		$data=$this->readByLine( $keys );
		
		while ( !is_null($data) ){
			
			$Result[]=$data;

			$data=$this->readByLine( $keys );

		}

		return $Result;

	}

	public function readByLine($keys=null){

		if(! $this->isOpen() ){

			$this->openFile();
		
		}

		if( $this->endOfFile() )
		{
			$this->closeFile();
			
			return null;
		}

		$Line=$this->getLine();

		if($this->isEmpty($Line)){
			
			return [];
		}

		if(is_null($keys)){
		
			$keys=$this->getKeys();
		
		}

		if(strcmp(substr($Line,-1),"\n")==0)
		{
			$Line=substr($Line, 0, -1);
		}
		
		$RawData=$this->getDataInLine($Line);

		return $this->CreateRowArray($keys,$RawData);

	}

	private function endOfFile()
	{

		return feof($this->Act_File);

	}

	private function getLine(){

		return fgets($this->Act_File);

	}

	private function getDataInLine(string $Line)
	{

		return explode($this->getDelimiter(), $Line);

	}

	private function getKeys()
	{

		return explode($this->getDelimiter(), $this->getFormat() );
	}

	private function isEmpty($Line)
	{	

		return $Line=="";

	}

	private function CreateRowArray($keys,$RawData)
	{

		$res=[];

		foreach ($keys as $index => $key) {

			$res[$key]=$RawData[$index];

		}

		return $res;

	}
}