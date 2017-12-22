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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'PagesController@getIndex')->name('main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});

Route::prefix('client')->group(function() {
	Route::get('/login', 'Auth\ClientLoginController@showLoginForm')->name('client.login');
	Route::post('/login', 'Auth\ClientLoginController@login')->name('client.login.submit');

	Route::get('/register', 'Auth\ClientRegisterController@showRegistrationForm')->name('client.register');
	Route::post('/register', 'Auth\ClientRegisterController@register')->name('client.register.submit');
	Route::get('/', 'ClientController@index')->name('client.dashboard');
});

Route::resource('jobs', 'Client\JobController');

//Route::post('freelancerPages/freelancerSearch', 'Freelancer\SearchController@index')->name('search');

Route::post('/search', 'Freelancer\SearchController@search')->name('search');

//Route::get('/postJobs', 'JobController@index')->name('postJobs');

