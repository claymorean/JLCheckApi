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

//Route::any('/', function () {
//    return view('welcome');
//});

Route::group(['prefix' => 'shenhe', 'namespace' => 'Api'], function () {
    Route::any('/get', 'Api@get');
    Route::any('/update', 'Api@update');
    Route::any('/submit', 'Api@submit');
    Route::any('/reject', 'Api@reject');
});
Route::group(['prefix' => 'shenpi', 'namespace' => 'Api'], function () {
    Route::any('/get', 'Api@approve');
    Route::any('/pass', 'Api@pass');
    Route::any('/refuse', 'Api@refuse');
    Route::any('/review', 'Api@review');
});