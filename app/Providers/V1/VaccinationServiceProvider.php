<?php

namespace App\Providers\V1;

use App\Modules\V1\Repositories\VaccinationRepository;
use App\Modules\V1\Services\VaccinationService;
use Illuminate\Support\ServiceProvider;

class VaccinationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            VaccinationRepository::class,
            VaccinationService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
