<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        //------------------------------------------------------------------
        //  This stops wrapping of Json Resources in more arrays
        //  automatically out to follow different way to achieve this
        //
        //  JsonResource::withoutWrapping();
        //------------------------------------------------------------------
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
