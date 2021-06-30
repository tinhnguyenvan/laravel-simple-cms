<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "console" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index');
Route::get('/login', 'LoginController@index');
Route::post('/auth', 'LoginController@auth');

Route::middleware(['auth.console'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/configs', 'ConfigController@index');
    Route::post('/configs/save', 'ConfigController@save');
    Route::post('/configs/test', 'ConfigController@test');
    Route::get('/logout', 'UserController@logout');

    // user
    Route::resource('users', 'UserController');
    Route::get('/users/reset-password/{id}', 'UserController@resetPassword');
    Route::post('/users/active/{id}', 'UserController@active');
    Route::post('/users/profile', 'UserController@show');
    Route::put('/users/update-reset-password/{id}', 'UserController@updateResetPassword');

    // members
    Route::resource('members', 'MemberController');
    Route::get('/members/reset-password/{id}', 'MemberController@resetPassword');
    Route::post('/members/active/{id}', 'MemberController@active');
    Route::put('/members/update-reset-password/{id}', 'MemberController@updateResetPassword');

    // media
    Route::delete('medias/destroy-multi', 'MediaController@destroyMulti');
    Route::resource('medias', 'MediaController');

    // ckeditor
    Route::post('ckeditor/upload', 'MediaController@upload');

    // roles
    Route::get('roles', 'RoleController@index');
    Route::get('roles/permission', 'RoleController@permission');
    Route::post('roles/permission', 'RoleController@updatePermission');

    // themes
    Route::get('themes', 'ThemeController@index');
    Route::get('themes/css', 'ThemeController@css');

    // plugins
    Route::get('plugins', 'ThemeController@index');

    // order
    Route::get('orders/report', 'OrderController@report');
    Route::get('orders/get-report', 'OrderController@getReport');
    Route::resource('orders', 'OrderController');
    Route::post('orders/resent-mail/{id}', 'OrderController@resentMail');
    Route::post('orders/status/{id}', 'OrderController@status');

    Route::resource('configs', 'ConfigController');

    //post
    Route::delete('posts/destroy-multi', 'PostController@destroyMulti');
    Route::resource('posts', 'PostController');

    // post tag
    Route::delete('post_tags/destroy-multi', 'PostTagController@destroyMulti');
    Route::resource('post_tags', 'PostTagController');
    Route::resource('post_categories', 'PostCategoryController');

    // product
    Route::delete('products/destroy-multi', 'ProductController@destroyMulti');
    Route::resource('products', 'ProductController');
    Route::resource('product_categories', 'ProductCategoryController');

    // comment
    Route::delete('comments/destroy-multi', 'CommentController@destroyMulti');
    Route::resource('comments', 'CommentController');
    Route::post('comments/status/{id}', 'CommentController@status');

    // nav
    Route::resource('navs', 'NavController');
    Route::resource('nav_positions', 'NavPositionController');

    // page
    Route::delete('pages/destroy-multi', 'PageController@destroyMulti');
    Route::resource('pages', 'PageController');
    Route::resource('ads', 'AdsController');

    // contact
    Route::delete('contacts/destroy-multi', 'ContactController@destroyMulti');
    Route::resource('contacts', 'ContactController');
    Route::resource('contact_forms', 'ContactFormController');

    // classified
    Route::delete('classifieds/destroy-multi', 'ClassifiedController@destroyMulti');
    Route::resource('classifieds', 'ClassifiedController');
    Route::resource('classified_categories', 'ClassifiedCategoryController');

    // college
    Route::get('colleges/import', 'CollegeController@import');
    Route::post('colleges/import', 'CollegeController@importHandle');
    Route::put('colleges/disabled', 'CollegeController@disabled');
    Route::put('colleges/enabled', 'CollegeController@enabled');
    Route::resource('colleges', 'CollegeController');
    Route::resource('college-scholarships', 'CollegeScholarshipController');

    // regions
    Route::resource('regions', 'RegionController');

    // tools qr_code
    Route::get('tools', 'ToolController@index');
    Route::get('tools/qr_code', 'ToolController@qrCode');
    Route::post('tools/qr_code', 'ToolController@handleQrCode');

    // tools short_link
    Route::get('tools/short_link', 'ToolController@shortLink');
    Route::get('tools/short_link/create', 'ToolController@createShortLink');
    Route::post('tools/short_link/create', 'ToolController@handleCreateShortLink');
});
