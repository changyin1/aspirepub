<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ClientQuestion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ClientQuestion::observe(ClientQuestionObserver::class);
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
