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



$router->group(['prefix' => 'courses'], function () use ($router){
    $router->get('/', 'CourseController@index');
    $router->get('/find', 'CourseController@find');
    $router->get('/{id}', 'CourseController@show');
    $router->post('/', 'CourseController@store');
    $router->put('/{id}', 'CourseController@update');
    $router->delete('/{id}', 'CourseController@destroy');
});


