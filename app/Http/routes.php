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
        Route::post('register/{index}/{type}', 'SuggestController@create');
        Route::delete('unregister/{index}/{type}', 'SuggestController@delete');
        Route::post('seed/{index}/{type}/{id?}', 'SuggestController@seed');
        Route::get('search/{index}/{field}/{text}', 'GetController@suggest');
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
//        Route::get('/', 'GetController@get');
//        Route::get('{index}/{type}/{id}', 'GetController@get');
//        Route::put('{index}/{type}/{id?}', 'GetController@create');
//        Route::delete('{index}/{type}/{id}', 'GetController@delete');
    });

//  Index Management API
Route::group(['namespace' => 'Api', 'prefix' => 'api'],
    function() {
//        Route::get('{index}', 'IndexController@get');
//        Route::put('{index}', 'IndexController@create');
//        Route::delete('{index}', 'IndexController@delete');

//        Route::group(['prefix' => 'api/suggest/open'],
//            function() {
//                Route::post('{index}', 'IndexController@open');
//            });
//        Route::group(['prefix' => 'api/suggest/close'],
//            function() {
//                Route::post('{index}', 'IndexController@close');
//            });
    });

//  Default
//Route::any('{any?}', 'DefaultController@handleRequest')->where('any', '.*');
