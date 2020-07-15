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

Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
});

Route::prefix('backoffice')->group(function() {
	Route::group(['prefix'=>'user','as'=>'admin.user.', 'middleware' => ['role:superadministrator|administrator']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'UserAdminController@index']);
		Route::get('/{id}/details', ['as' => 'show', 'uses' => 'UserAdminController@show']);
		Route::get('/create', ['as' => 'create', 'uses' => 'UserAdminController@create']);
		Route::post('', ['as' => 'store', 'uses' => 'UserAdminController@store']);
		Route::get('/{id}/edit/', ['as' => 'edit', 'uses' => 'UserAdminController@edit']);
		Route::match(['put', 'patch'], '/{id}/update', ['as' => 'update', 'uses' => 'UserAdminController@update']);
		Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'UserAdminController@destroy']);
	});
});
