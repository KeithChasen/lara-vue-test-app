<?php
Route::group(
    ['prefix' => 'auth'], function ($router) {
    $router->post('register', ['as' => 'auth.register', 'uses' => 'AuthController@register']);
    $router->post('login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    $router->post('me', ['as' => 'auth.me', 'uses' => 'AuthController@me']);
    $router->group(['middleware' => 'jwt.check'], function ($router) {
        $router->post('auth/refresh', ['as' => 'auth.refresh', 'uses' => 'AuthController@refresh']);
        $router->post('logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
    });
});

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::prefix('users')->group(function ($router) {
        $router->get('/', 'UserController@index');
        $router->get('/{id}', 'UserController@show');
        $router->delete('/{id}', 'UserController@destroy');
        $router->put('/{id}', 'UserController@update');
        $router->post('/', 'UserController@store');
    });

    Route::prefix('photos')->group(function ($router) {
        $router->get('/', 'PhotoController@index');
        $router->get('/{id}', 'PhotoController@show');
        $router->delete('/{id}', 'PhotoController@destroy');
        $router->put('/{id}', 'PhotoController@update');
        $router->post('/', 'PhotoController@store');
    });

});
