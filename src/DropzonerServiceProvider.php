<?php namespace Jaspur\Dropzoner;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DropzonerServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot()
    {
        $packageRoutesPath = __DIR__ . '/Http/routes.php';
        $packageConfigPath = __DIR__ . '/config/dropzoner.php';
        $packageViewsPath  = __DIR__ . '/../views';
        $packageAssetsPath = __DIR__ . '/../assets';

        include $packageRoutesPath;

        $config = config_path('dropzoner.php');

        if (file_exists($config)) {
            $this->mergeConfigFrom($packageConfigPath, 'dropzoner');
        }

        $this->publishes([
            $packageConfigPath => $config,
        ], 'config');
        $this->loadViewsFrom($packageViewsPath, 'pages');

        $this->publishes([
            $packageAssetsPath => public_path('vendor/dropzoner'),
        ], 'public');

        // $this->loadViewsFrom(realpath(__DIR__ . '/../views'), 'dropzoner', __DIR__);
        // $this->setupRoutes($this->app->router);

        // $this->publishes([__DIR__ . '/config/dropzoner.php' => config_path('dropzoner.php')]);
        // $this->publishes([__DIR__ . '/../assets' => public_path('vendor/dropzoner')], 'public');
    }

    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Jaspur\Dropzoner\Http\Controllers'], function ($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    public function register()
    {
        $this->app->singleton('dropzoner', function ($app) {
            return new Dropzoner;
        });

        // $this->registerDropzoner();
        // config(['config/dropzoner.php']);
    }

    public function registerDropzoner()
    {
        $this->app->bind('dropzoner', function ($app) {
            return new Dropzoner($app);
        });
    }

    public function provides()
    {
        return ['dropzoner'];
    }
}
