<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::resource('/todos', 'TodosController');
    Route::post('/todos/search', 'TodosController@search');
});

Route::get('/', function () {
    if(Auth::guest()) {
        return redirect()->guest('login');
    } else {
        return redirect('/todos');
    }
});

Route::auth();

Route::get('/home', 'TodosController@index');
