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
        return redirect(route('start'));
    else
        return redirect(route('home'));
})->name('/');


// Events
Route::get('home', 'EventController@list')->name('home');
Route::get('events/{id}', 'EventController@show');


// Groups
Route::get('groups', 'EventController@list')->name('groups');
Route::get('groups/{id}', 'GroupController@show');


// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

//Profile
Route::get('profile/{id}', 'CardController@list')->name('profile')->where('id', '[0-9]+');


// Authentication

Route::get('start', 'Auth\LoginController@showLoginForm')->name('start');
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