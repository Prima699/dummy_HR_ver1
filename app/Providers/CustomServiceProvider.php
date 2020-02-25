<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		require_once app_path() . '/Helpers/Auth.php';
		require_once app_path() . '/Helpers/Constants.php';
		require_once app_path() . '/Helpers/DateTimes.php';
		require_once app_path() . '/Helpers/Digitas.php';
		require_once app_path() . '/Helpers/Cookies.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
