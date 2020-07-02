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

Route::group(['middleware' => ['role:super-admin|admin'], 'prefix' => 'backoffice'], function () {
    Route::get('/', 'BackofficeController@index')->name('admin.dashboard');
});
