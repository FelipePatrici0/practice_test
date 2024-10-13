<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CarrierRepository;
use App\Repositories\DriverRepository;
use App\Repositories\ModelTruckRepository;
use App\Repositories\TruckRepository;
use App\Repositories\CarrierDriverRepository;

use App\Repositories\Interfaces\CarrierRepositoryInterface;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use App\Repositories\Interfaces\ModelTruckRepositoryInterface;
use App\Repositories\Interfaces\TruckRepositoryInterface;
use App\Repositories\Interfaces\CarrierDriverRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CarrierRepositoryInterface::class, CarrierRepository::class);
        $this->app->bind(DriverRepositoryInterface::class, DriverRepository::class);
        $this->app->bind(ModelTruckRepositoryInterface::class, ModelTruckRepository::class);
        $this->app->bind(TruckRepositoryInterface::class, TruckRepository::class);
        $this->app->bind(CarrierDriverRepositoryInterface::class, CarrierDriverRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
