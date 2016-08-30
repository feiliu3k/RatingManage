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

Route::group(['namespace'=>'Admin','middleware'=>'auth'],function(){
    Route::resource('admin/fre', 'FreController', ['except' => 'show']);
    Route::resource('admin/ratingtype', 'RatingTypeController', ['except' => 'show']);

    Route::get('admin/upload', 'UploadController@index');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');

    Route::get('excel/export','ExcelController@export');
    Route::get('excel/import','ExcelController@import');

});



Route::get('login','Auth\AuthController@showLoginForm');
Route::post('login','Auth\AuthController@login');
Route::get('logout','Auth\AuthController@logout');
