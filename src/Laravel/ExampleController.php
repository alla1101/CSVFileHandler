<?php 

namespace a2la1101\csvhandler\Laravel;

use App\Http\Controllers\Controller;

class ExampleController extends Controller {

  public function __construct() {

  }

  public static function getCSVFileFromCommand($commandName)
  { 

    $fileHandler=app("CSVHandlerService")->createFileHandler($commandName);

    $data=$fileHandler->readAll();

    return $data;
  }

}