<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('index');
// });

// Route::get('/login', function()
// {
// 	return View::make('login');
// });

Route::get('/', array('as' => 'index', 'uses' => 'berryController@home'));

Route::get('login', array('as' => 'login', 'uses' => 'berryController@log'));

Route::get('register', array('as' => 'register', 'uses' => 'berryController@reg'));

