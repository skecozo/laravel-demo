<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers',

    ], function ($api) {
        $api->get('github','AuthController@redirectToProvider')->middleware('web');
        $api->get('github/login','AuthController@handleProviderCallback')->middleware('web');
        $api->get('github/get','AuthController@gettoken')->middleware('web');

        $api->post('user/register','AuthController@register');
        $api->post('user/login','AuthController@login');
        $api->get('user/getuserinfo','AuthController@getuserinfo')->middleware('jwt.auth');

        $api->get('user/userinfo/{id}','AuthController@userinfo');

        $api->get('user/{id}/follower','AuthController@follower')->middleware('jwt.auth');
        $api->get('user/getmessage','AuthController@getMessage')->middleware('jwt.auth');
        $api->get('user/markasread/{id}','AuthController@markasread')->middleware('jwt.auth');
        $api->get('user/markasread','AuthController@markallread')->middleware('jwt.auth');

        $api->get('email/verify/{token}',['as'=>'email.verify','uses' =>'EmailController@verify']);



        $api->get('article','ArticleController@index');
        $api->post('article','ArticleController@store')->middleware('jwt.auth');
        $api->get('article/{id}','ArticleController@show');
        $api->get('article/{id}/like','ArticleController@like')->middleware('jwt.auth');
        $api->post('serach','ArticleController@serach');





        $api->post('comment','CommentController@store')->middleware('jwt.auth');
        $api->post('comment/reply','CommentController@replystore')->middleware('jwt.auth');

        $api->get('article/{id}/comment','CommentController@article');
        $api->get('comment/{id}/comment','CommentController@comment');


        $api->put('comment/{id}','CommentController@update')->middleware('jwt.auth');
        $api->delete('comment/{id}','CommentController@destroy')->middleware('jwt.auth');


        $api->get('tags','TagController@index');
        $api->get('activity','ActivityController@show');


        $api->post('upload','uploadController@uploadFile')->middleware('jwt.auth');

    });
});