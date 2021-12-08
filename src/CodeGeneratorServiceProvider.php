<?php

namespace Generator;

use Digidinos\CodeGenerator\Console\Commands\BaseCommand;
use Digidinos\CodeGenerator\Console\Commands\GenerateAPICommand;
use Digidinos\CodeGenerator\Console\Commands\GenerateNuxtCommand;
use Illuminate\Support\ServiceProvider;

class CodeGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../templates/api', 'api-templates');

        $this->publishes([
            __DIR__.'/../config/generator.php' => config_path('generator.php'),
            __DIR__.'/../templates/api' => resource_path('views/vendor/api-templates'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                BaseCommand::class,
                GenerateAPICommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/generator.php',
            'generator'
        );
    }
}
