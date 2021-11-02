<?php

namespace Kangyasin\LaravelFlip;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;

class ServiceProvider extends BaseServiceProvider
{

    /*
        for lumen version <=5.2, just copy the migrations from the package directory
    */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/flip.php', 'flip');

        $databasePath = __DIR__.'/../database/migrations';
        if ($this->isLumen()) {
            $this->loadMigrationsFrom($databasePath);
        } else {
            $this->publishes([$databasePath => database_path('migrations')], 'migrations');
        }

        if (class_exists(Application::class)) {
            $this->publishes(
                [
                    __DIR__.'/../config/flip.php' => config_path('flip.php'),
                ],
                'config'
            );
        }


        if (config('flip.route.enabled')) {
            $this->registerRoutes();
        }

    }


    protected function registerRoutes()
    {
        $router = $this->app['router'];
        require __DIR__.'/../routes/web.php';
        require __DIR__.'/../routes/api.php';

    }

    protected function isLaravel()
    {
        return app() instanceof \Illuminate\Foundation\Application;
    }

    protected function isLumen()
    {
        return !$this->isLaravel();
    }
  }
