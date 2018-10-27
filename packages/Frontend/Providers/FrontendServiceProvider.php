<?php
namespace Frontend\Providers;

use Illuminate\Support\ServiceProvider;
use igaster\laravelTheme\Facades\Theme;
use Illuminate\Http\Request;

class FrontendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('request',function(){
            return new Request();
        });
        $this->publishes([
            __DIR__.'/../Config/frontend.php' => config_path('frontend.php'),
        ]);
    }

    public function boot(){
        $this->boot_theme();
        require __DIR__ . '/../Http/routes.php';
        require  __DIR__.'/../Helpers/FrontendHelper.php';
        $this->loadViewsFrom(__DIR__.'/../Views/FrontEnd/'.Theme::find(config('frontend.urlView'))->viewsPath,'FrontEnd');
        $this->loadTranslationsFrom(__DIR__.'/../Locale','FrontEnd');
    }

    private function boot_theme(){
        \Theme::set(config('frontend.urlView'));
        \Theme::find(config('frontend.urlView'))->viewsPath = config('frontend.urlView');
        \Theme::find(config('frontend.urlView'))->themesPath = '';
        \Theme::find(config('frontend.urlView'))->assetPath = '';
        \Theme::configSet('title', 'LADO - ALL IN ONE');
    }
}