<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        require_once app_path() . '/Helpers/Common.php';
        require_once app_path() . '/Helpers/Images.php';
        require_once app_path() . '/Helpers/User.php';
    }
}
