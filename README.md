# CSV File Handler Project [A Draft]

This package is made to ease file handling with configuration and config validation.

## Remaining Goals

To validate each line in the file when writing.
To validate each line before writing.
To use illuminate library (validation) without laravel !
To loade configurations without config function in laravel

## Goals
To work easily with laravel framework
To work with other frameworks with relative ease.

## current limitations
Main limit is the need for laravel framework to use the package

## Getting Started

1- create config folder in laravel main directory, add the files found in a2la1101/csvhandler/config to it.
2- add configurations to the copied files.
3- In lumen, add the following code to app.php
```
$app->register(a2la1101\csvhandler\Laravel\CSVHandlerServiceProvider::class);
$app->configure('CSVHandler');
```
everything is now set and ready to be used.

## how to use :
before starting, go to a2la1101\csvhandler\config, and read how to configure csvHandler Example.

1) to Read :
```
$fileHandler=app("CSVHandlerService")->createFileHandler("READTEST");

print_r($fileHandler->readByLine());

print_r($fileHandler->readAll());

```

2) to write :

to call handler for writing
```
$fileHandler=app("CSVHandlerService")->createFileHandler("WRITETEST");
```
suppose you have a $DataArray
```
[
	["x"=>"a1","y"=>"b1","z"=>1],
	["x"=>"a2","y"=>"b2","z"=>2],
	["x"=>"a3","y"=>"b3","z"=>3],
	["x"=>"a4","y"=>"b4","z"=>4],
]
```
To Write By Line
```
$fileHandler->writeByLine($DataArray[0]) ;
.
.
.
// if you have finished writing and want to close file
$fileHandler->writeByLine(null);
```
To Write All
```
print_r($fileHandler->writeAll($DataArray));
```