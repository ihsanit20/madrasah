<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    CONST BANGLA_OF_GREGORIAN_MONTHS = [
        "01" => "জানুয়ারি",
        "02" => "ফেব্রুয়ারি",
        "03" => "মার্চ",
        "04" => "এপ্রিল",
        "05" => "মে",
        "06" => "জুন",
        "07" => "জুলাই",
        "08" => "আগস্ট",
        "09" => "সেপ্টেম্বর",
        "10" => "অক্টোবর",
        "11" => "নভেম্বর",
        "12" => "ডিসেম্বর"
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_ENV') == 'production') {
            $this->app['request']->server->set('HTTPS','on');
        }
    }
}
