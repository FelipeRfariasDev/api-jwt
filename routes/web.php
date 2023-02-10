<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/novo_usuario', 'AuthController@novo_usuario');
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->post('/logout', 'AuthController@logout');
        $router->get('/cursos', 'CursoController@index');
        $router->post('/cursos', 'CursoController@store');
        $router->put('/cursos/{id}', 'CursoController@update');
        $router->delete('/cursos/{id}', 'CursoController@destroy');

    });
});
