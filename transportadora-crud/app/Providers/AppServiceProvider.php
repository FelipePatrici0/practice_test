<?php

namespace App\Providers;

use App\Repositories\CaminhaoRepositoryEloquent;
use App\Repositories\Interfaces\CaminhaoRepositoryInterface;
use App\Repositories\Interfaces\ModeloRepositoryInterface;
use App\Repositories\Interfaces\MotoristaRepositoryInterface;
use App\Repositories\Interfaces\TransportadoraRepositoryInterface;
use App\Repositories\ModeloRepositoryEloquent;
use App\Repositories\MotoristaRepositoryEloquent;
use App\Repositories\TransportadoraRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $this->app->bind(TransportadoraRepositoryInterface::class, TransportadoraRepositoryEloquent::class);
        $this->app->bind(MotoristaRepositoryInterface::class, MotoristaRepositoryEloquent::class);
        $this->app->bind(CaminhaoRepositoryInterface::class, CaminhaoRepositoryEloquent::class);
        $this->app->bind(ModeloRepositoryInterface::class, ModeloRepositoryEloquent::class);
    }
}
