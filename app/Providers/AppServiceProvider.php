<?php

namespace App\Providers;

use App\Http\Controllers\Utils;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        
        Validator::extend('document', function ($attribute, $value, $parameters, $validator) {
           
            return Utils::cpfIsValid($value);
        });
    }
}
