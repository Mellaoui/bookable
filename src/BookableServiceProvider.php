<?php

namespace Mellaoui\Bookable;

use Exception;
use Illuminate\Support\ServiceProvider;

class BookableServiceProvider extends ServiceProvider
{
    /**
     * @throws Exception
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

    }

    public function register()
    {

    }
}