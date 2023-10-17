<?php

namespace Mellaoui\Bookable;

use Illuminate\Support\ServiceProvider;

class BookableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishables();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bookable.php', 'bookable');
    }

    protected function registerPublishables(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/bookable.php' => config_path('bookable.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
