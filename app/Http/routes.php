<?php
//******************************************************************************
//* Application routes
//******************************************************************************

//  Front-end
//Route::get('/', ['uses' => 'AppController@index']);
//Route::get('home', ['uses' => 'AppController@index']);

//  Auto-suggest API (api/suggest)
Route::group(['namespace' => 'Api', 'prefix' => 'api/suggest'],
    function() {
        Route::post('register/{index}/{type}/', 'SuggestController@create');
        Route::delete('unregister/{index}/{type}', 'SuggestController@delete');

        Route::post('seed/{index}/{type}/{id?}', 'DocController@seed');
        Route::get('search/{index}/{type}/{text}', 'DocController@suggest');
    });

//  Index Management API
Route::group(['namespace' => 'Api', 'prefix' => 'api/index'],
    function() {
        Route::get('{index}', 'IndexController@get');
        Route::put('{index}', 'IndexController@create');
        Route::delete('{index}', 'IndexController@delete');
    });

//  Default API (api/)
Route::group(['namespace' => 'Api', 'prefix' => 'api'],
    function() {
        //  Server info
        Route::get('info', 'DefaultController@info');
    });

//  Document API
Route::group(['namespace' => 'Api', 'prefix' => 'api/doc'],
    function() {
//        Route::get('/', 'DocController@get');
//        Route::get('{index}/{type}/{id}', 'DocController@get');
//        Route::put('{index}/{type}/{id?}', 'DocController@create');
//        Route::delete('{index}/{type}/{id}', 'DocController@delete');
    });

//  Default
//Route::any('{any?}', 'DefaultController@handleRequest')->where('any', '.*');
