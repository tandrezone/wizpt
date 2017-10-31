<?php

namespace wizpt\cms;

use Illuminate\Support\ServiceProvider;
use wizpt\cms\Console\CmsMakeCommand;
use wizpt\cms\Middleware\setLang;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CmsMakeCommand::class,
            ]);
        }
        $router->middleware('setlang', 'setLang');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
