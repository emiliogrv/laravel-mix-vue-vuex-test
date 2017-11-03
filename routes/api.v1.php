<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['prefix' => 'excel', 'as' => 'excel', 'middleware' => []], function () {
    Route::get('/', ['as' => '.index', 'uses' => 'ExcelController@index']);
    Route::get('export', ['as' => '.export', 'uses' => 'ExcelController@export']);
    Route::post('/', ['as' => '.store', 'uses' => 'ExcelController@store']);
    Route::put('{id}', ['as' => '.update', 'uses' => 'ExcelController@update']);
    Route::delete('{id}', ['as' => '.destroy', 'uses' => 'ExcelController@destroy']);
});
