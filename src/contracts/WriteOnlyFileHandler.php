<?php

namespace a2la1101\csvhandler\Contracts;

interface WriteOnlyFileHandler{
	
	public function writeAll();

	public function writeByLine();
	
}