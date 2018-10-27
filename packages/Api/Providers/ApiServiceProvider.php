<?php
namespace Api\Providers;
use Illuminate\Support\ServiceProvider;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Http\Request;

class ApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('request',function(){
             return new Request();
        });
        $this->publishes([
            __DIR__.'/../Config/api.php' => config_path('api.php'),
        ]);
    }

    public function boot(){
        require __DIR__ . '/../Http/routes.php';
        require  __DIR__.'/../Helpers/ApiHelper.php';
        $this->loadTranslationsFrom(__DIR__.'/../Locale','Api');
    }

}