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

Route::prefix('media')->group(function() {
    Route::get('/', 'MediaController@index');
});

Route::prefix('backoffice')->group(function() {
	Route::group(['prefix'=>'media','as'=>'admin.media.', 'middleware' => ['role:superadministrator|administrator']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'MediaAdminController@index']);
		Route::post('', ['as' => 'store', 'uses' => 'MediaAdminController@store']);
	});
});
