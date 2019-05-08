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


Route::post('events/{event}/comments', 'CommentController@store');
Route::get('events/{event}/comments', 'CommentController@getAllComments');
Route::delete('api/comments/{id}', 'CommentController@delete');

Route::get('event/create', 'EventController@create');
Route::post('event/create', 'EventController@store')->name('createEvent');
Route::post('events/{event}/invitations', 'EventController@addParticipant');

Route::post('events/{event}/file','EventController@getFile');

// Groups
Route::get('groups/{id}', 'GroupController@show');

// User
Route::get('user/{id}', 'ProfileController@show')->name('profile')->where('id', '[0-9]+');

// Pesquisa
Route::post('search/users', 'UserController@searchUsers');

// API
Route::post('api/events/{id}/presence/', 'UserController@participation');
Route::put('api/users/{id}', 'ProfileController@edit');

// Authentication

Route::get('start', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('start', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@show');
Route::post('register', 'RegistrationRequestController@create');

//FAQ
Route::view('/faq','pages.faq');

//About
Route::view('/about', 'pages.about');


// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::get('/dash', 'AdminController@list')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/registers/{id}', 'AdminController@store');
    Route::delete('/registers/{id}', 'AdminController@destroy');
});


// Notifications
Route::view('notifications','pages/notifications');

Auth::routes();
