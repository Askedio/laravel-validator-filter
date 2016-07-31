<?php

namespace Askedio\LaravelValidatorFilter;

use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('validator')->extend('filter', function ($attribute, $value, $parameters, $validator) {
            new Filter($attribute, $value, $parameters, $validator);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->register('Rees\Sanitizer\SanitizerServiceProvider');
    }
}
