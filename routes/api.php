<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group(['prefix' => 'api/v1/'], function($router) {

    $router->post('users/login/', 'UserController@authenticate');

    $router->get('users/me/', [
        'middleware' => 'auth',
        'uses' => 'UserController@getCurrent'
    ]);
    $router->get('users/logout/', [
        'middleware'=>'auth',
        'uses' => 'UserController@deleteToken'
    ]);

    $router->post('products/', [
        'middleware'=>'auth',
        'uses' => 'ProductController@store'
    ]);

    $router->get('products/{id}', [
        'middleware'=>'auth',
        'uses' => 'ProductController@show'
    ]);

    $router->get('products/', [
        'middleware'=>'auth',
        'uses' => 'ProductController@showList'
    ]);

    $router->put('products/{id}', [
        'middleware'=>'auth',
        'uses' => 'ProductController@update'
    ]);
});

$router->options('/api/v1[/{slug}]', function(){
    return response()->json([]);
});