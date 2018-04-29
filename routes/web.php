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

Route::get('/', 'MainController@news');

Auth::routes();

Route::get('/dashboard', 'DashboardController@dashboard')->middleware('auth');

Route::post("/locale", 'MainController@locale');

Route::get('/apps', "AppController@get");

Route::post('/app/create', 'AppController@create')->middleware('auth');
Route::get('/app/{uid}/edit', 'AppController@showEditPage')->middleware('auth');
Route::post('/app/edit', 'AppController@edit')->middleware('auth');

Route::post('/upload/apk', 'UploadController@apk')->middleware('auth');
Route::post('/upload/icon', 'UploadController@icon')->middleware('auth');
Route::post('/upload/banner', 'UploadController@banner')->middleware('auth');
Route::post('/upload/avatar', 'UploadController@avatar')->middleware('auth');
Route::post('/upload/story', 'UploadController@story')->middleware('auth');

Route::get('/download/preview-apk/{uid}', 'DownloadController@previewApk')->middleware('auth');

Route::get('/dashboard/apps', 'DashboardController@showApps')->middleware('auth');
Route::get('/dashboard/users', 'DashboardController@showUsers')->middleware('auth');
Route::get('/dashboard/roles', 'DashboardController@showRoles')->middleware('auth');
Route::get('/dashboard/profile', 'DashboardController@showProfile')->middleware('auth');
Route::get('/dashboard/stories', 'DashboardController@showStories')->middleware('auth');


Route::get('/role/edit/{id}', 'RoleController@showEditPage')->middleware('auth');
Route::get('/role/delete/{id}', 'RoleController@delete')->middleware('auth');
Route::post('/role/edit', 'RoleController@edit')->middleware('auth');
Route::post('/role/create', 'RoleController@create')->middleware('auth');

Route::get('/story/edit/{uid}/{vid?}', 'StoryController@showEditPage')->middleware('auth');
Route::post('/story/edit', 'StoryController@edit')->middleware('auth');
Route::post('/story/create', 'StoryController@create')->middleware('auth');


Route::get('/user/edit/{username}', 'UserController@showUser')->middleware('auth');
Route::post('/user/edit', 'UserController@edit')->middleware('auth');

Route::get('/test', 'TestController@test');
