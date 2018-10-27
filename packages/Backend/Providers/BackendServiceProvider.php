<?php
namespace Backend\Providers;
use Illuminate\Support\ServiceProvider;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Http\Request;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('request',function(){
             return new Request();
        });
        $this->publishes([
            __DIR__.'/../Config/backend.php' => config_path('backend.php'),
        ]);
    }

    public function boot(){
        $this->boot_theme();
        require __DIR__ . '/../Http/routes.php';
        require  __DIR__.'/../Helpers/BackendHelper.php';

        $this->loadViewsFrom(__DIR__.'/../Views/BackEnd/'.Theme::find(config('backend.urlView'))->viewsPath,'BackEnd');
        $this->loadTranslationsFrom(__DIR__.'/../Locale','BackEnd');
    }

    private function boot_theme(){
        \Theme::set(config('backend.urlView'));
        \Theme::find(config('backend.urlView'))->viewsPath = config('backend.urlView');
        \Theme::find(config('backend.urlView'))->themesPath = '';
        \Theme::configSet('title', 'Cms - All in one');
    }
}