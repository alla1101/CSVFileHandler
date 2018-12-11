<?php

namespace a2la1101\csvhandler\Laravel;

use Illuminate\Support\ServiceProvider;

use a2la1101\csvhandler\FileHandler\FileHandlerFactory;
use a2la1101\csvhandler\FileHandler\ConfigurationProvider;

class CSVHandlerServiceProvider extends ServiceProvider
{

    public function boot()
    {
        include __DIR__.'/routes.php';     
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    	$this->app->singleton('CSVHandlerService', function(){

            $configProvider=new ConfigurationProvider();
        
            $factory=new FileHandlerFactory();

            $factory->setConfigurationProvider($configProvider);

            return $factory;
        });
    }
}