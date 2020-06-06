<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Admin route
Route::get('/admin', 'Admin\AdminController@redirect')->name('admin');
Route::get('/admin/login', 'Admin\AdminController@showLoginView')->name('admin.login');
Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
