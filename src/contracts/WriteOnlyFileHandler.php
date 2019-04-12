<?php

namespace a2la1101\csvhandler\contracts;

interface WriteOnlyFileHandler{
	
	public function writeAll($AllLinesData);

	public function writeByLine($OneLineData,$keys);
	
}