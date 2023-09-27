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

Route::post('/doLogin', 'ProjectConTroller@doLogin')->name('doLogin');
Route::get('/doLogout', 'ProjectConTroller@doLogout')->name('doLogout');

Route::get('/getBannersForFeedback/{project_id}/{id}', 'ProjectController@getBannersForFeedback')->name('getBannersForFeedback');
Route::get('/getCategoryData/{project_id}/{id}', 'ProjectConTroller@getCategoryData')->name('getCategoryData');
Route::get('/getFeedbackName/{id}', 'ProjectConTroller@getFeedbackNameDate')->name('getFeedbackNameDate');
Route::get('/getBannersData/{categoryId}', 'ProjectController@getBannersData')->name('getBannersData');
Route::get('/getFeedbackData/{project_id}/{feedbackId}', 'ProjectController@getFeedbackData')->name('getFeedbackData');
Route::get('/getBannerSizeinfo/{size_id}', 'ProjectController@getBannerSizeinfo')->name('getBannerSizeinfo');
Route::get('/getFeedbackcategoryCount/{feedback_id}', 'ProjectConTroller@getFeedbackcategoryCount')->name('getFeedbackcategoryCount');

Route::get('/project/banner/view/{id}', 'ProjectConTroller@banner_view')->name('banner_view');
Route::get('/project/video/view/{id}', 'ProjectConTroller@video_view')->name('video_view');
Route::get('/project/gif/view/{id}', 'ProjectConTroller@gif_view')->name('gif_view');
Route::get('/project/social/view/{id}', 'ProjectConTroller@social_view')->name('social_view');
Route::get('/project/banner-showcase/view/{id}', 'ProjectConTroller@banner_showcase_view')->name('banner_showcase_view');
Route::get('/project/video-showcase/view/{id}', 'ProjectConTroller@video_showcase_view')->name('video_showcase_view');
Route::post('/set_color/{id}', 'ProjectConTroller@set_color')->name('set_color');
Route::post('/setVersionStatus/{version_id}', 'ProjectConTroller@setVersionViewStatus')->name('setVersionViewStatus');
Route::post('/setFeedbackStatus/{version_id}', 'ProjectConTroller@setFeedbackStatus')->name('setFeedbackStatus');

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

// Route::get('/getVideoSizeInfo/{id}', 'HomeController@getVideoSizeInfo')->name('getVideoSizeInfo');

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

//banner showcase function starts
Route::get('/banner-showcase', 'bannerShowcaseController@bannerShowcaseList')->name('bannerShowcaseList');
Route::get('/project/banner-showcase/add', 'bannerShowcaseController@banner_project_add_view')->name('banner_project_add_view');
Route::post('/project/banner-showcase/add', 'bannerShowcaseController@banner_project_add_post')->name('banner_project_add_post');
Route::get('/project/banner-showcase/edit/{id}', 'bannerShowcaseController@banner_project_edit_view')->name('banner_project_edit_view');
Route::post('/project/banner-showcase/edit/{id}', 'bannerShowcaseController@banner_project_edit_post')->name('banner_project_edit_post');
Route::get('/project/banner-showcase/addon/{id}', 'bannerShowcaseController@banner_add_feedback_view')->name('banner_add_feedback_view');
Route::post('/project/banner-showcase/addon/{id}', 'bannerShowcaseController@banner_add_feedback_post')->name('banner_add_feedback_post');
Route::get('/project/banner-showcase/delete/{id}', 'bannerShowcaseController@banner_project_delete')->name('banner_project_delete');
Route::get('/banner/add/feedback/{project_id}/{feedback_id}', 'bannerShowcaseController@banner_add_category_view')->name('banner_add_category_view');
Route::post('/banner/add/feedback/{project_id}/{feedback_id}', 'bannerShowcaseController@banner_add_category_post')->name('banner_add_category_post');
Route::get('/banner/edit/feedback/{project_id}/{feedback_id}', 'bannerShowcaseController@banner_edit_feedback_view')->name('banner_edit_feedback_view');
Route::post('/banner/edit/feedback/{project_id}/{feedback_id}', 'bannerShowcaseController@banner_edit_feedback_post')->name('banner_edit_feedback_post');
Route::get('/banner/delete/feedback/{project_id}/{feedback_id}', 'bannerShowcaseController@banner_delete_feedback')->name('banner_delete_feedback');
Route::get('/banner/categories/{feedback_id}/edit/{category_id}', 'bannerShowcaseController@banner_edit_category_view')->name('banner_edit_category_view');
Route::post('/banner/categories/{feedback_id}/edit/{category_id}', 'bannerShowcaseController@banner_edit_category_post')->name('banner_edit_category_post');
Route::get('/banner/categories/{feedback_id}/delete/{category_id}', 'bannerShowcaseController@banner_delete_category')->name('banner_delete_category');
Route::get('/delete-all-banners-showcase/{project_id}', 'bannerShowcaseController@banner_index_view_delete')->name('banner_index_view_delete');
Route::get('/showcase/edit/{id}', 'bannerShowcaseController@showcase_banner_edit')->name('showcase_banner_edit');
Route::post('/showcase/edit/{id}', 'bannerShowcaseController@showcase_banner_edit_post')->name('showcase_banner_edit_post');
Route::get('/showcase/delete/{id}', 'bannerShowcaseController@banner_delete')->name('banner_delete');
Route::get('/showcase/download/{id}', 'bannerShowcaseController@banner_download')->name('banner_download');
//baner showcase function ends

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
Route::get('/social', 'SocialController@view_socials_list')->name('view_socials_list');
Route::get('/project/social/add', 'SocialController@add_socials')->name('add_socials');
Route::post('/project/social/add', 'SocialController@add_socials_post')->name('add_socials_post');
Route::get('/project/social/edit/{id}', 'SocialController@social_edit_view')->name('social_edit_view');
Route::post('/project/social/edit/{id}', 'SocialController@social_edit_post')->name('social_edit_post');

Route::get('/project/social/addon/{id}', 'SocialController@social_addon')->name('social_addon');
Route::post('/project/social/addon/{id}', 'SocialController@social_addon_post')->name('social_addon_post');

Route::get('/social/edit/{id}', 'SocialController@social_edit_single')->name('social_edit_single');
Route::post('/social/edit/{id}', 'SocialController@social_edit_single_post')->name('social_edit_single_post');
Route::get('/social/delete/{id}', 'SocialController@social_single_delete')->name('social_single_delete');
Route::get('/project/social/delete/{id}', 'SocialController@social_project_delete')->name('social_project_delete');
Route::get('/delete-all-socials/{id}', 'SocialController@delete_all_socials')->name('delete_all_socials');
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

//planetnine billing function starts
Route::get('/bills', 'PDFController@billing_list')->name('billing_list');
Route::get('/bills/add', 'PDFController@create_billing')->name('create_billing');
Route::post('/bills/add', 'PDFController@create_billing_post')->name('create_billing_post');
Route::get('bills/view/{id}', 'PDFController@view_bills')->name('view_bills');
Route::get('/bills/delete/{id}', 'PDFController@delete_bill')->name('delete_bill');
//planetnine billing function ends




//video showcase function starts

Route::get('/video-showcase', 'VideoShowcaseController@video_list')->name('videoshowcaselist');
Route::get('/project/video-showcase/add', 'VideoShowcaseController@videoshowcase_add_view')->name('videoshowcaseaddview');
Route::post('/project/video-showcase/add', 'VideoShowcaseController@videoshowcase_add_post')->name('videoshowcaseaddpost');
Route::get('/project/video-showcase/edit/{id}', 'VideoShowcaseController@videoshowcase_edit_view')->name('videoshowcase_edit_view');
Route::post('/project/video-showcase/edit/{id}', 'VideoShowcaseController@videoshowcase_edit_post')->name('videoshowcase_edit_post');
Route::get('/project/video-showcase/delete/{id}', 'VideoShowcaseController@videoshowcase_delete')->name('videoshowcase_delete');
Route::get('/video-showcase/edit/{id}', 'VideoShowcaseController@video_edit_view')->name('videoshowcase_video_edit');
Route::post('/video-showcase/edit/{id}', 'VideoShowcaseController@video_edit_post')->name('videoshowcase_video_edit_post');
Route::get('/video-showcase/delete/{id}', 'VideoShowcaseController@video_delete')->name('videoshowcase_video_delete');
Route::get('/project/video-showcase/addon/{id}', 'VideoShowcaseController@videoshowcase_addon_view')->name('videoshowcase_addon_view');
Route::post('/project/video-showcase/addon/{id}', 'VideoShowcaseController@videoshowcase_addon_post')->name('videoshowcase_addon_post');
Route::get('/video/add/feedback/{project_id}/{feedback_id}', 'VideoShowcaseController@video_feedback_add_view')->name('video_feedback_add_view');
Route::post('/video/add/feedback/{project_id}/{feedback_id}', 'VideoShowcaseController@video_feedback_add_post')->name('video_feedback_add_post');
Route::get('/video/edit/feedback/{project_id}/{feedback_id}', 'VideoShowcaseController@video_feedback_edit_view')->name('video_feedback_edit_view');
Route::post('/video/edit/feedback/{project_id}/{feedback_id}', 'VideoShowcaseController@video_feedback_edit_post')->name('video_feedback_edit_post');
Route::get('/video/delete/feedback/{project_id}/{feedback_id}', 'VideoShowcaseController@video_delete_feedback')->name('video_delete_feedback');

//video showcase function ends


//gif showcase function starts

Route::get('/gif-showcase', 'GifShowcaseController@gif_list')->name('gifshowcaselist');

//gif showcase function ends

//social showcase function starts

Route::get('/social-showcase', 'SocialShowcaseController@social_list')->name('socialshowcaselist');

//social showcase function ends


Route::get('/talpa', function (){
    return view('talpa_project.index');
});

Route::get('/project/preview/view/{id}', 'ViewController@view');

Route::get('/view-previews', 'PreviewController@viewPreviews');
Route::get('/project/preview/add', 'PreviewController@addPreviewsView');
Route::post('/project/preview/add', 'PreviewController@addPreviewsPost');
Route::get('/project/preview/edit/{id}', 'PreviewController@editPreviewView');
Route::post('/project/preview/edit/{id}', 'PreviewController@editPreviewPost');

Route::get('/project/preview/banner/edit/{id}', 'PreviewController@bannerEditView');
Route::post('/project/preview/banner/edit/{id}', 'PreviewController@bannerEditPost');
Route::get('/project/preview/banner/download/{id}', 'PreviewController@bannerDownload');

Route::get('/project/preview/banner/add/version/{id}', 'PreviewController@bannerAddVersionView');
Route::post('/project/preview/banner/add/version/{id}', 'PreviewController@bannerAddVersionPost');

Route::get('/getProjectType/{id}', 'axiosController@getProjectType');
Route::get('/getNewFeedbackName/{id}', 'axiosController@getNewFeedbackName');
Route::get('/getNewBannersData/{id}', 'axiosController@getNewBannersData');
Route::get('/deleteBanner/{id}', 'axiosController@deleteBanner');
Route::get('/getVersionsFromFeedback/{id}', 'axiosController@getVersionsFromFeedback');