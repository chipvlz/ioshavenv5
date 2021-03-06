<?php

Auth::routes();

Route::get('/', 'MainController@news');
Route::post("/locale", 'MainController@locale');
Route::get('/apps', "MainController@apps");
Route::get('/test', 'TestController@test');
Route::post('/test', 'TestController@upload');

Route::prefix('dashboard')->group(function () {
  Route::get('/', 'DashboardController@dashboard');
  Route::get('/apps', 'DashboardController@showApps');
  Route::get('/logs', 'DashboardController@showLogs');
  Route::get('/users', 'DashboardController@showUsers');
  Route::get('/roles', 'DashboardController@showRoles');
  Route::get('/profile', 'DashboardController@showProfile');
  Route::get('/stories', 'DashboardController@showStories');
});

Route::prefix('app')->group(function () {
  Route::get('/edit/{uid}/{vid?}', 'AppController@showEditPage');
  Route::get('{uid}', 'MainController@showApp');
  Route::post('/edit', 'AppController@edit');
  Route::post('/create', 'AppController@create');
});

Route::prefix('upload')->group(function () {
  Route::post('/apk', 'UploadController@apk');
  Route::post('/ipa', 'UploadController@ipa');
  Route::post('/icon', 'UploadController@icon');
  Route::post('/banner', 'UploadController@banner');
  Route::post('/avatar', 'UploadController@avatar');
  Route::post('/story', 'UploadController@story');
});

Route::prefix('download')->group(function () {
  Route::get('/raw/{session}/{random}', 'DownloadController@downloadRaw');
  Route::get('/app/{type}/{uid}/{vid?}', 'MainController@downloadApp');
  Route::post('/app', 'DownloadController@app');
});

Route::prefix('role')->group(function () {
  Route::get('/edit/{id}', 'RoleController@showEditPage');
  Route::get('/delete/{id}', 'RoleController@delete');
  Route::post('/edit', 'RoleController@edit');
  Route::post('/create', 'RoleController@create');
});

Route::prefix('story')->group(function () {
  Route::get('/edit/{uid}/{vid?}', 'StoryController@showEditPage');
  Route::get('/{uid}', 'MainController@showStory');
  Route::post('/edit', 'StoryController@edit');
  Route::post('/create', 'StoryController@create');
});

Route::prefix('user')->group(function () {
  Route::get('/edit/{username}', 'UserController@showUser');
  Route::post('/edit', 'UserController@edit');
});

Route::prefix('action')->group(function () {
  Route::post('like', 'MainController@like');
});

Route::prefix('stats')->group(function () {
  Route::get('downloads/{format?}/{limit?}', 'StatsController@getDownloads');
  Route::get('likes/{type}/{format?}/{limit?}', 'StatsController@getLikes');
  Route::get('views/{type}/{format?}/{limit?}', 'StatsController@getViews');
});
