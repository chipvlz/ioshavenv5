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

Route::get('/', function () {
    // App::setLocale("es");
    // config(['app.locale' => 'en']);
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post("/locale", 'MainController@locale');


Route::get('/app/create', 'AppController@create')->middleware('auth');
Route::get('/app/{uid}/edit', 'AppController@showEditPage')->middleware('auth');
Route::post('/app/edit', 'AppController@edit')->middleware('auth');

Route::post('/upload/apk', 'UploadController@apk')->middleware('auth');
Route::post('/upload/icon', 'UploadController@icon')->middleware('auth');
Route::post('/upload/banner', 'UploadController@banner')->middleware('auth');

Route::get('/download/preview-apk/{uid}', 'DownloadController@previewApk')->middleware('auth');
Route::get('/preview/image/{folder}/{file}', 'DownloadController@previewImage')->middleware('auth');
