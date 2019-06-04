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

Route::get('/', 'HomeController@list')->name('/');


//HomePage
Route::get('home', 'HomeController@list')->name('home');

// Events
Route::get('events/{id}', 'EventController@show');
Route::post('events', 'EventController@getEvents');


Route::post('events/{event}/comments', 'CommentController@store');
Route::get('events/{event}/comments', 'CommentController@getAllComments');
Route::delete('api/comments/{id}', 'CommentController@delete');

Route::get('event/create', 'EventController@create');
Route::post('event/create', 'EventController@store')->name('createEvent');
Route::post('events/{event}/invitations', 'EventController@addParticipant');

Route::post('events/{event}/file', 'EventController@getFile');

// Groups
Route::get('groups/{id}', 'GroupController@show');
Route::get('group/create', 'GroupController@create');
Route::post('group/create', 'GroupController@store')->name('createGroup');

// User
Route::get('user/{id}', 'ProfileController@show')->name('profile')->where('id', '[0-9]+');

// Pesquisa
Route::post('search/users', 'UserController@searchUsers');
Route::post('search/groups', 'GroupController@searchGroups');
Route::get('search','SearchController@show');


// API
Route::post('api/events/{id}/presence/', 'UserController@participation');
Route::put('api/users/{id}', 'ProfileController@edit');
Route::get('api/users/{id}/wards', 'UserController@getWards');

// Authentication

Route::get('start', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('start', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@show');
Route::post('registerParent','RegistrationRequestController@createWithParent');
Route::post('register', 'RegistrationRequestController@store');

//FAQ
Route::view('/faq', 'pages.faq');

//About
Route::view('/about', 'pages.about');

//Parent accout management
Route::get('/parent','ParentController@changeAccount');

//Manage section
Route::get('/manage-section/{id}','ManageSectionController@show');
Route::post('/manage-section/{id}','ManageSectionController@store');

// Admin Authentication
Route::prefix('/admin')->group(function () {

    Route::get('/requests', 'AdminController@drawRequests')->name('admin.requests');
    Route::get('/users', 'AdminController@drawUsers')->name('admin.users');
    Route::get('/guardians', 'AdminController@drawGuardians')->name('admin.guardians');
    Route::get('/sections', 'AdminController@drawSections')->name('admin.sections');

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::post('/registers/{id}', 'AdminController@store');
    Route::delete('/registers/{id}', 'AdminController@destroy');


    Route::delete('/users/{id}', 'AdminController@removeUser');

    Route::get('/searchUsers', 'AdminController@searchUsers')->name('admin.searchUsers');
});


// Notifications
Route::view('notifications', 'pages/notifications');

//Auth::routes();
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('mbway','MBWayClientController@test');