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

Route::group(['middleware' => ['manager', 'verified'], 'namespace' => 'manager', 'prefix' => 'manager', 'as' => 'manager.'], function () {
    Route::get('searchuser', 'TaskController@searchuser')->name('searchuser');
    Route::resource('task', 'TaskController')->except(['searchuser']);
});

Route::group(['middleware' => ['developer', 'verified'], 'namespace' => 'developer', 'prefix' => 'developer', 'as' => 'developer.'], function () {
    Route::resource('task', 'TaskController')->only(['index', 'edit', 'update', 'show']);
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);
