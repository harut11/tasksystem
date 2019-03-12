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

Route::group(['namespace' => 'manager'], function () {
   Route::get('tasks', 'TaskController@index')->name('index');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
