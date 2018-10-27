<?php
Route::group(['prefix' => 'api'], function () {
    Route::any('/', 'Api\\Controllers\\IndexController@index');
    Route::any('auth/register', 'Api\\Controllers\\AuthController@register');
    Route::any('auth/login', 'Api\\Controllers\\AuthController@login');
    Route::any('auth/GetToken', 'Api\\Controllers\\AuthController@GetToken');

    Route::group(['middleware' => 'AuthenticateApiToken:api'],function (){
        Route::any('packages', 'Api\\Controllers\\PackagesController@index');
    });
});

