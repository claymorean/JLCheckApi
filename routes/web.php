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
    Route::get('/get', 'Api@get');
    Route::get('/update', 'Api@update');
    Route::get('/submit', 'Api@submit');
    Route::get('/reject', 'Api@reject');
    Route::get('/approve', 'Api@approve');
    Route::get('/pass', 'Api@pass');
    Route::get('/refuse', 'Api@refuse');
    Route::get('/review', 'Api@review');
});