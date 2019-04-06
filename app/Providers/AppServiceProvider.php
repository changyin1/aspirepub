<?php

namespace App\Providers;

use App\Nova\Schedule;
use App\Observers\ScheduleObserver;
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
        \App\Schedule::observe(ScheduleObserver::class);
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
