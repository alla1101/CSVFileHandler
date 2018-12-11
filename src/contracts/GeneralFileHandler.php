<?php

namespace a2la1101\csvhandler\contracts;

interface GeneralFileHandler{

	public function openConnection();

	public function closeConnection($ActualFile);

	public function getFileDirectory();

	public function setFileDirectory(String $directory);

	public function getPermission();

	public function isFile();

	public function isReadable();

	public function isWritable();

	public function setFormat(string $format);

	public function getFormat();

	public function getDelimiter();

	public function setDelimiter(string $delimiter);

}