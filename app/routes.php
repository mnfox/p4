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

Route::group(array('before' => 'logged'), function()
{
   Route::get('/', array('as' => 'index', 'uses' => 'berryController@home'));
});

Route::filter('logged', function()
{
    if (Auth::check()) return Redirect::to('member');
});

Route::get('member', array('as' => 'member', 'uses' => 'berryController@member'))->before('auth');
Route::post('member', array('uses' => 'berryController@flagEdit'));

Route::get('login', array('as' => 'showlogin', 'uses' => 'berryController@showLogin'));
Route::post('login', array('uses' => 'berryController@doLogin'));

Route::get('logout', array('as' => 'logout', 'uses' => 'berryController@doLogout'));

Route::get('register', array('as' => 'register', 'uses' => 'berryController@showReg'));
Route::post('register', array('uses' => 'berryController@doReg'));

Route::get('create', array('as' => 'create', 'uses' => 'berryController@showEvent'))->before('auth');
Route::post('create', array('uses' => 'berryController@createEvent'));

Route::get('edit', array('as' => 'edit', 'uses' => 'berryController@showEdit'));
Route::post('edit', array('uses' => 'berryController@doEdit'));

Route::get('delete', array('as' => 'delete', 'uses' => 'berryController@deleteEvent'));

Route::get('join', array('as' => 'join', 'uses' => 'berryController@joinEvent'));

Route::get('unjoin', array('as' => 'unjoin', 'uses' => 'berryController@unjoinEvent'));

?>