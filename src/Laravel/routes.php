<?php

Route::group(['namespace' => 'a2la1101\csvhandler\Laravel'], function()
{
    Route::get('file/{commandName}', ['uses' => 'ExampleController@getCSVFileFromCommand']);
});