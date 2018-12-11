<?php

namespace a2la1101\csvhandler\Contracts;

interface ReadOnlyFileHandler{
	
	public function readAll();

	public function readByLine();

}