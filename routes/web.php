<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'check', 'namespace' => 'Api'], function () {
    Route::get('/get', 'Api@getInfo');
//    Route::get('/', ['as' => 'aftermarket', 'uses' => 'AfterMarketController@index']);
//    Route::get('/feedback', ['as' => 'aftermarket_feedback', 'uses' => 'AfterMarketController@getFeedback']);
//    Route::delete('/feedback/{id}', 'AfterMarketController@delete');
//    Route::post('/feedback/batch', 'AfterMarketController@batchDelete');
//    Route::get('/feedback/search', 'AfterMarketController@search');
});