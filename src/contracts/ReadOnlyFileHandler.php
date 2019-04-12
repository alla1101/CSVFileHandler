<?php

namespace a2la1101\csvhandler\contracts;

interface ReadOnlyFileHandler{
	
	public function readAll();

	public function readByLine();

}