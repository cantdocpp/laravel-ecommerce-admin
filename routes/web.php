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

// Admin routes
Route::get('/admin', 'Admin\AdminController@redirect')->name('admin');
Route::get('/admin/login', 'Admin\AdminController@showLoginView')->name('admin.login');
Route::get('/admin/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
Route::get('/admin/users', 'Admin\UserController@index')->name('admin.users');
Route::get('/admin/users/create', 'Admin\UserController@create')->name('admin.users.create');
Route::post('/admin/users', 'Admin\UserController@store')->name('admin.users.store');

// API routes
Route::prefix('api')->group(function () {
    Route::get('admin/users', 'Admin\UserController@getUserTableData')->middleware('cors');
    Route::delete('/admin/users/{user}', 'Admin\UserController@destroy')->name('admin.users.destroy');
    Route::delete('/admin/users/', 'Admin\UserController@bulkDestroy')->name('admin.users.bulk.destroy');
});
