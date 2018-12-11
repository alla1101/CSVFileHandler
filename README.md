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
1) to Read :
```
$fileHandler=app("CSVHandlerService")->createFileHandler("READTEST");

print_r($fileHandler->readByLine());

print_r($fileHandler->readAll());

```

## TODO
Making write to file functionality