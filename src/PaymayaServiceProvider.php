<?php

namespace Stonedleaf\PaymayaLaravel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Stonedleaf\PaymayaLaravel\Console\Commands\InstallWebhook;

class PaymayaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/paymaya.php', 'paymaya'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootRoutes();
        $this->bootMigrations();
        $this->bootPublishing();
    }

    /**
     * Register routes
     * 
     * @return void
     */
    protected function bootRoutes()
    {
        if (Paymaya::$registerRoutes) {
            Route::group([
                'prefix' => config('paymaya.path'),
                'namespace' => 'Stonedleaf\PaymayaLaravel\Http\Controllers',
                'as' => 'paymaya.',
            ], function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
        }
    }

    /**
     * Reegister migrations
     * 
     * @return void
     */
    protected function bootMigrations()
    {
        if (Paymaya::$runMigrations && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }
    }

    /**
     * Publishes resources
     * 
     * @return void
     */
    protected function bootPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/paymaya.php' => $this->app->configPath('paymaya.php'),
            ]);
            $this->commands([InstallWebhook::class]);
        }
    }
}
