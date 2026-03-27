<?php

namespace LechugaNegra\PrivKeyManager\Providers;

use Illuminate\Support\ServiceProvider;
use LechugaNegra\PrivKeyManager\Middleware\PrivKeyMiddleware;

class PrivKeyManagerProvider extends ServiceProvider
{
    /**
     * Realizar el registro de servicios.
     *
     * @return void
     */
    public function register() {}

    /**
     * Realizar las configuraciones necesarias.
     *
     * @return void
     */
    public function boot()
    {
        // Registrar comandos Artisan
        if ($this->app->runningInConsole()) {
            $this->commands([
                \LechugaNegra\PrivKeyManager\Console\Commands\CreatePrivKey::class,
            ]);
        }

        // Registrar el middleware en el Kernel de la aplicación
        $this->app['router']->aliasMiddleware('priv.key', PrivKeyMiddleware::class);

        // Cargar rutas de api.php
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
    }   
}
