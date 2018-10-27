<?php
Route::group(['middleware' => ['web', 'AuthenticateFrontend']], function () {
    Route::any('/', function ($param = null) {
        return App::make("Frontend\\Controllers\\IndexController")->index($param);
    });
});