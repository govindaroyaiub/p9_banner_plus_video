<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:cache');

    return '<h2 style="color: red;">Cache, View, Config, Route cleared!</h2>';
});


Route::get('/project/banner/view/{id}', 'ProjectConTroller@banner_view')->name('banner_view');
Route::get('/project/video/view/{id}', 'ProjectConTroller@video_view')->name('video_view');
Route::get('/project/gif/view/{id}', 'ProjectConTroller@gif_view')->name('gif_view');
Route::post('/set_color/{id}', 'ProjectConTroller@set_color')->name('set_color');
Route::post('/setVersionStatus/{version_id}', 'ProjectConTroller@setVersionViewStatus')->name('setVersionViewStatus');

Route::get('/p9_transfer/download/all/{slug}', 'TransferController@download_all')->name('download_all');

Route::domain('https://creative.fusionlab.nl')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::domain('https://creative.me-preview.nl')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});

// Route::get('/get_comments/{id}', 'ProjectConTroller@get_comments')->name('get_comments');
// Route::post('/store_comments/{id}', 'ProjectConTroller@store_comments')->name('store_comments');

Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/add', 'HomeController@add_user')->name('add_user');
Route::post('/user/add', 'HomeController@add_user_post')->name('add_user_post');
Route::get('/user/edit/{id}', 'HomeController@edit_user')->name('edit_user');
Route::post('/user/edit/{id}', 'HomeController@edit_user_post')->name('edit_user_post');
Route::get('/user/delete/{id}', 'HomeController@delete_user')->name('delete_user');
Route::get('/change-password', 'HomeController@change_password')->name('change_password');
Route::post('/change-password', 'HomeController@change_password_post')->name('change_password_post');
Route::get('/reset-password/{id}', 'HomeController@reset_password')->name('reset_password');

// Route::post('/change_mail_status', 'HomeController@change_mail_status')->name('change_mail_status');

//banner functions and routes
Route::get('/banner', 'BannerController@index')->name('banner');
Route::get('/project/banner/add', 'BannerController@banner_add')->name('banner_add');
Route::post('/project/banner/add', 'BannerController@banner_add_post')->name('banner_add_post');
Route::get('/project/banner/edit/{id}', 'BannerController@project_edit')->name('project_edit');
Route::post('/project/banner/edit/{id}', 'BannerController@project_edit_post')->name('project_edit_post');
Route::get('/project/banner/delete/{id}', 'BannerController@banner_delete_all')->name('banner_delete_all');
Route::get('/project/banner/addon/{id}', 'BannerController@project_addon')->name('banner_addon');
Route::post('/project/banner/addon/{id}', 'BannerController@project_addon_post')->name('banner_addon_post');
Route::get('/banner/edit/{id}', 'BannerController@banner_edit')->name('banner_edit');
Route::post('/banner/edit/{id}', 'BannerController@banner_edit_post')->name('banner_edit_post');
Route::get('/banner/delete/{id}', 'BannerController@banner_delete')->name('banner_delete');

Route::get('/banner_sizes', 'BannerController@sizes')->name('banner_sizes');
Route::get('/banner_sizes/add', 'BannerController@size_add')->name('banner_sizes_add');
Route::post('/banner_sizes/add', 'BannerController@size_add_post')->name('banner_sizes_add_post');
Route::get('/banner_sizes/delete/{id}', 'BannerController@size_delete')->name('banner_sizes_delete');
Route::get('/delete-all-banners/{id}', 'BannerController@deleteAllBanners')->name('deleteAllBanners');

Route::get('/banner/add/version/{project_id}/{version_id}', 'BannerController@addBannerVersion')->name('addBannerVersion');
Route::post('/banner/add/version/{project_id}/{version_id}', 'BannerController@addBannerVersionPost')->name('addBannerVersionPost');
Route::get('/banner/edit/version/{project_id}/{version_id}', 'BannerController@editBannerVersion')->name('editBannerVersion');
Route::post('/banner/edit/version/{project_id}/{version_id}', 'BannerController@editBannerVersionPost')->name('editBannerVersionPost');
Route::get('/delete/version/{project_id}/{version_id}', 'BannerController@deleteVersion')->name('deleteVersion');
//banner functions and routes end

//video functions and routes
Route::get('/video', 'HomeController@project')->name('project');
Route::get('/project/video/add', 'HomeController@project_add')->name('project_add');
Route::post('/project/video/add', 'HomeController@project_add_post')->name('project_add_post');
Route::get('/project/video/edit/{id}', 'HomeController@project_edit')->name('project_edit');
Route::post('/project/video/edit/{id}', 'HomeController@project_edit_post')->name('project_edit_post');
Route::get('/project/video/delete/{id}', 'HomeController@project_delete')->name('project_delete');
Route::get('/project/video/addon/{id}', 'HomeController@project_addon')->name('project_addon');
Route::post('/project/video/addon/{id}', 'HomeController@project_addon_post')->name('project_addon_post');
Route::get('/video/edit/{id}', 'HomeController@video_edit')->name('video_edit');
Route::post('/video/edit/{id}', 'HomeController@video_edit_post')->name('video_edit_post');
Route::get('/video/delete/{id}', 'HomeController@video_delete')->name('video_delete');

Route::get('/sizes', 'HomeController@sizes')->name('sizes');
Route::get('/sizes/add', 'HomeController@size_add')->name('size_add');
Route::post('/sizes/add', 'HomeController@size_add_post')->name('size_add_post');
Route::get('/sizes/delete/{id}', 'HomeController@size_delete')->name('size_delete');
//video functions and routes end

//GIF functions start
Route::get('/gif', 'GifController@index')->name('gif_index');
Route::get('/project/gif/add', 'GifController@gif_add')->name('gif_add');
Route::post('/project/gif/add', 'GifController@gif_add_post')->name('gif_add_post');
Route::get('/project/gif/edit/{id}', 'GifController@project_edit')->name('project_edit');
Route::post('/project/gif/edit/{id}', 'GifController@project_edit_post')->name('project_edit_post');
Route::get('/project/gif/delete/{id}', 'GifController@gif_delete_all')->name('gif_delete_all');
Route::get('/project/gif/addon/{id}', 'GifController@project_addon')->name('gif_addon');
Route::post('/project/gif/addon/{id}', 'GifController@project_addon_post')->name('gif_addon_post');
Route::get('/gif/edit/{id}', 'GifController@gif_edit')->name('gif_edit');
Route::post('/gif/edit/{id}', 'GifController@gif_edit_post')->name('gif_edit_post');
Route::get('/gif/delete/{id}', 'GifController@gif_delete')->name('banner_delete');
//GIF functions end

//Social Images functions start

//Social images fucntions end

//Logo function starts
Route::get('/logo', 'HomeController@client')->name('logo');
Route::get('/logo/add', 'HomeController@client_add')->name('logo_add');
Route::post('/logo/add', 'HomeController@logo_add_post')->name('logo_add_post');
Route::get('/logo/edit/{id}', 'HomeController@logo_edit')->name('logo_edit');
Route::post('/logo/edit/{id}', 'HomeController@logo_edit_post')->name('logo_edit_post');
Route::get('/logo/delete/{id}', 'HomeController@logo_delete')->name('logo_delete');
//Logo function ends

//Planetnine transfer starts
Route::resource('/p9_transfer', 'TransferController')->name('*', 'p9_transfer');
//Planetnine transfer ends