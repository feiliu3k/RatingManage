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

    Route::get('admin/ratinglist/search', 'RatingListController@search');
    Route::post('admin/ratinglist/deletebycondition', 'RatingListController@deleteByCondition');
    Route::get('admin/ratinglist/fileexplorer', 'RatingListController@fileExplorer');
    Route::post('admin/ratinglist/import', 'RatingListController@import');
    Route::resource('admin/ratinglist', 'RatingListController', ['except' => ['show','create']]);

    Route::get('admin/adplaylist/search', 'ADPlayListController@search');
    Route::post('admin/adplaylist/deletebycondition', 'ADPlayListController@deleteByCondition');
    Route::get('admin/adplaylist/fileexplorer', 'ADPlayListController@fileExplorer');
    Route::post('admin/adplaylist/import', 'ADPlayListController@import');
    Route::resource('admin/adplaylist', 'ADPlayListController', ['except' => ['show','create']]);

    Route::get('admin/statlist/search', 'StatListController@search');
    Route::post('admin/statlist/stat', 'StatListController@stat');
    Route::post('admin/statlist/save', 'StatListController@save');
    Route::post('admin/statlist/export', 'StatListController@export');
    Route::get('admin/statlist/download', 'StatListController@download');
    Route::post('admin/statlist/deletebycondition', 'StatListController@deleteByCondition');
    Route::get('admin/statlist/fileexplorer', 'StatListController@fileExplorer');
    Route::post('admin/statlist/import', 'StatListController@import');
    Route::resource('admin/statlist', 'StatListController', ['except' => ['show','create','edit','store','update']]);

    Route::get('admin/upload', 'UploadController@index');
    Route::post('admin/upload/file', 'UploadController@uploadFile');
    Route::delete('admin/upload/file', 'UploadController@deleteFile');
    Route::post('admin/upload/folder', 'UploadController@createFolder');
    Route::delete('admin/upload/folder', 'UploadController@deleteFolder');

});



Route::get('login','Auth\AuthController@showLoginForm');
Route::post('login','Auth\AuthController@login');
Route::get('logout','Auth\AuthController@logout');
