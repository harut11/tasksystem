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


Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'manager', 'namespace' => 'manager', 'prefix' => 'manager', 'as' => 'manager.'], function () {
    Route::group(['prefix' => 'task', 'as' => 'task.'], function () {
        Route::get('/', 'TaskController@index')->name('index');
        Route::get('create', 'TaskController@create')->name('create');
        Route::post('store', 'TaskController@store')->name('store');
        Route::get('edit/{id}', 'TaskController@edit')->name('edit');
        Route::post('update/{id}', 'TaskController@update')->name('update');
        Route::post('{id}', 'TaskController@destroy')->name('delete');
        Route::get('show/{id}', 'TaskController@show')->name('show');
    });
});

Route::group(['middleware' => 'developer', 'namespace' => 'developer', 'prefix' => 'developer', 'as' => 'developer.'], function () {
    Route::group(['prefix' => 'task', 'as' => 'task.'], function () {
        Route::get('/', 'TaskController@index')->name('index');
        Route::get('edit/{id}', 'TaskController@edit')->name('edit');
        Route::post('update/{id}', 'TaskController@update')->name('update');
        Route::get('show/{id}', 'TaskController@show')->name('show');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/searchuser', 'AutocompleteController@searchuser')->name('searchuser');

Auth::routes();
