<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Msg91Service;

class Msg91ServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Msg91Service::class, function ($app) {
            return new Msg91Service(config('services.msg91.auth_key'), config('services.msg91.sender_id'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
