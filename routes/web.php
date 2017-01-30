<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
Route::get('/text', function () {
   Cache::put('foo','ba',10);
    return Cache::get('foo');
});

/*Route::get('login', 'HomeController@handleProviderCallback');*/




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::get('/{path?}', function () {
    return view('example');
})->where('path', '[\/\w\.-]*');


