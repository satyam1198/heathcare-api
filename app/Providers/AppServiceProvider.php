<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {        
        Schema::defaultStringLength(191);   
    }
}
