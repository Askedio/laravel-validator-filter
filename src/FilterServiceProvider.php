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
        $this->app->singleton('filter', function () {
            return new Filter();
        });

        app('validator')->extend('filter', function ($attribute, $value, $parameters, $validator) {
            app('filter')->run($attribute, $value, $parameters, $validator);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
