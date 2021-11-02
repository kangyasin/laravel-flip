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


        if (config('flip.route.enabled')) {
            $this->registerRoutes();
        }

        $this->registerFlipConfig();
        $this->registerFlipModule();
        $this->registerFlipController();
        $this->registerFlipHelper();
        $this->registerFlipException();
        $this->registerFlipTraits();


    }
    protected function registerRoutes()
    {
        $router = $this->app['router'];
        require './routes/web.php';
        require './routes/api.php';
    }

    protected function registerFlipConfig()
    {
      $this->mergeConfigFrom('./config/flip.php', 'flip');
      $this->publishes([
        $this->packagePath('./config/flip.php') => base_path('flip.php'),
      ], 'config');
    }


    protected function registerFlipModule()
    {
      $this->publishes([
        $this->packagePath('Flip/Flip.php') => base_path('app/Flip'),
      ], 'FlipModule');
    }

    protected function registerFlipController()
    {
      $this->publishes([
        $this->packagePath('Http/Controllers/SnapController.php') => base_path('app/Http/Controllers'),
      ], 'Controllers');
    }

    protected function registerFlipHelper()
    {
      $this->publishes([
        $this->packagePath('Helpers/ResponseHelper.php') => base_path('app/Helpers'),
      ], 'Helpers');
    }

    protected function registerFlipException()
    {
      $this->publishes([
        $this->packagePath('Exceptions/FlipException.php') => base_path('app/Exceptions'),
      ], 'Exceptions');
    }

    protected function registerFlipTraits()
    {
      $this->publishes([
        $this->packagePath('Traits/ChannelLogging.php') => base_path('app/Traits'),
      ], 'Traits');
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
