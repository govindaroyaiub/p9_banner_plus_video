<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/project/banner/view/{id}', 'ProjectConTroller@banner_view')->name('banner_view');
Route::get('/project/video/view/{id}', 'ProjectConTroller@video_view')->name('video_view');
Route::get('/get_comments/{id}', 'ProjectConTroller@get_comments')->name('get_comments');
Route::get('/get_colors/{id}', 'ProjectConTroller@get_colors')->name('get_colors');
Route::post('/set_color/{id}', 'ProjectConTroller@set_color')->name('set_color');
Route::post('/store_comments/{id}', 'ProjectConTroller@store_comments')->name('store_comments');

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
Route::post('/change_mail_status', 'HomeController@change_mail_status')->name('change_mail_status');

Route::get('/banner', 'BannerController@index')->name('banner');
Route::get('/banner/add', 'BannerController@banner_add')->name('banner_add');
Route::post('/banner/add', 'BannerController@banner_add_post')->name('banner_add_post');
// Route::get('/banner/edit/{id}', 'BannerController@project_edit')->name('banner_edit');
// Route::post('/banner/edit/{id}', 'BannerController@project_edit_post')->name('banner_edit_post');
// Route::get('/banner/delete/{id}', 'BannerController@project_delete')->name('banner_delete');
Route::get('/banner/addon/{id}', 'BannerController@project_addon')->name('banner_addon');
Route::post('/banner/addon/{id}', 'BannerController@project_addon_post')->name('banner_addon_post');

Route::get('/video', 'HomeController@project')->name('project');
Route::get('/video/add', 'HomeController@project_add')->name('project_add');
Route::post('/video/add', 'HomeController@project_add_post')->name('project_add_post');
Route::get('/video/edit/{id}', 'HomeController@project_edit')->name('project_edit');
Route::post('/video/edit/{id}', 'HomeController@project_edit_post')->name('project_edit_post');
Route::get('/video/delete/{id}', 'HomeController@project_delete')->name('project_delete');
Route::get('/video/addon/{id}', 'HomeController@project_addon')->name('project_addon');
Route::post('/video/addon/{id}', 'HomeController@project_addon_post')->name('project_addon_post');

Route::get('/logo', 'HomeController@client')->name('logo');
Route::get('/logo/add', 'HomeController@client_add')->name('logo_add');
Route::post('/logo/add', 'HomeController@logo_add_post')->name('logo_add_post');
Route::get('/logo/delete/{id}', 'HomeController@logo_delete')->name('logo_delete');

Route::get('/banner_sizes', 'BannerController@sizes')->name('banner_sizes');
Route::get('/banner_sizes/add', 'BannerController@size_add')->name('banner_sizes_add');
Route::post('/banner_sizes/add', 'BannerController@size_add_post')->name('banner_sizes_add_post');
Route::get('/banner_sizes/delete/{id}', 'BannerController@size_delete')->name('banner_sizes_delete');

Route::get('/sizes', 'HomeController@sizes')->name('sizes');
Route::get('/sizes/add', 'HomeController@size_add')->name('size_add');
Route::post('/sizes/add', 'HomeController@size_add_post')->name('size_add_post');
Route::get('/sizes/delete/{id}', 'HomeController@size_delete')->name('size_delete');

Route::get('/video/edit/{id}', 'HomeController@video_edit')->name('video_edit');
Route::post('/video/edit/{id}', 'HomeController@video_edit_post')->name('video_edit_post');
Route::get('/video/delete/{id}', 'HomeController@video_delete')->name('video_delete');