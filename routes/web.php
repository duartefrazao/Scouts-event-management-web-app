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
    if (!Auth::check())
        return redirect(route('login'));
    else
        return redirect(route('home'));
})->name('/');

// Events
Route::get('home', 'EventController@list')->name('home');
Route::get('events/{id}', 'EventController@show');

// Groups
Route::get('groups/{id}', 'GroupController@show');

//Profile
Route::get('profile/{id}', 'CardController@list')->name('profile')->where('id', '[0-9]+');


// API
Route::post('api/events/{id}/presence/', 'UserController@participation');

// Authentication

Route::get('start', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('start', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::get('/dash', 'AdminController@list')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});