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

Route::get('/', function () {

    return redirect('admin/fre');

});

Route::auth();


Route::group(['namespace'=>'Admin','middleware'=>'auth'],function(){
    Route::resource('admin/fre', 'FreController', ['except' => 'show']);
    Route::resource('admin/ratingtype', 'RatingTypeController');
});

Route::get('login','Auth\AuthController@showLoginForm');
Route::post('login','Auth\AuthController@login');
Route::get('logout','Auth\AuthController@logout');