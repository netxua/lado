<?php
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'PermissionBackend']], function () {
    Route::any('/', function ($param = null) {
        return App::make("Backend\\Controllers\\IndexController")->index($param);
    });
});


