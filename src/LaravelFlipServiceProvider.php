<?php

namespace Kangyasin\LaravelFlip;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelFlipServiceProvider extends ServiceProvider
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
        require __DIR__.'/../routes/web.php';
        require __DIR__.'/../routes/api.php';
    }

    protected function registerFlipConfig()
    {
      $this->publishes([
          __DIR__.'/../config/flip.php' => config_path('flip.php'),
      ], 'config');
    }


    protected function registerFlipModule()
    {
      $this->publishes([
        __DIR__.'/Flip/Flip.php' => app_path('Flip/Flip.php'),
      ], 'Flip');
    }

    protected function registerFlipController()
    {
      $this->publishes([
        __DIR__.'/Http/Controllers/SnapController.php' => app_path('Http/Controllers/SnapController.php'),
      ], 'Controllers');
    }

    protected function registerFlipHelper()
    {
      $this->publishes([
        __DIR__.'/Helpers/ResponseHelper.php' => app_path('Helpers/ResponseHelper.php'),
      ], 'Helpers');
    }

    protected function registerFlipException()
    {
      $this->publishes([
        __DIR__.'/Exceptions/FlipException.php' => app_path('Exceptions/FlipException.php'),
      ], 'Exceptions');
    }

    protected function registerFlipTraits()
    {
      $this->publishes([
        __DIR__.'/Traits/ChannelLogging.php' => app_path('Traits/ChannelLogging.php'),
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
