<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    // Rotas públicas
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    // Rotas de Usuário Logado
    $router->group(['middleware' => 'auth'], function () use ($router) {

        // Rotas para usuarios 'client'
        $router->get('/tasks', 'TaskController@index');
        $router->post('/tasks', 'TaskController@create');
        $router->get('/tasks/{id}', 'TaskController@show');
        $router->put('/tasks/{id}', 'TaskController@update');
        $router->delete('/tasks/{id}', 'TaskController@delete');

        // Rotas para usuarios 'admin'
        $router->group(['middleware' => 'admin'], function () use ($router) {

            $router->get('/admin/tasks', 'TaskController@adminIndex');
            $router->get('/admin/tasks/{userId}', 'TaskController@userTasks');

            $router->get('/users', 'UserController@index');
            $router->get('/users/{id}', 'UserController@show');
            $router->put('/users/{id}', 'UserController@update');
            $router->delete('/users/{id}', 'UserController@delete');
            $router->post('/users/{id}/promote', 'UserController@promote');
        });
    });
});


// $router->get('/tasks', 'TaskController@index');
// $router->post('/tasks', 'TaskController@create');
// $router->put('/tasks/{id}', 'TaskController@update');
// $router->delete('/tasks/{id}', 'TaskController@delete');
