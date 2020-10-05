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

Route::prefix('category')->group(function() {
    Route::get('/', 'CategoryController@index');
});

Route::prefix('backoffice')->group(function() {
	Route::group(['prefix'=>'category','as'=>'admin.category.', 'middleware' => ['role:superadministrator|administrator']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'CategoryAdminController@index']);
		Route::get('/{id}/details', ['as' => 'show', 'uses' => 'CategoryAdminController@show']);
		Route::get('/create', ['as' => 'create', 'uses' => 'CategoryAdminController@create']);
		Route::post('', ['as' => 'store', 'uses' => 'CategoryAdminController@store']);
		Route::get('/{id}/edit/', ['as' => 'edit', 'uses' => 'CategoryAdminController@edit']);
		Route::match(['put', 'patch'], '/{id}/update', ['as' => 'update', 'uses' => 'CategoryAdminController@update']);
		Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'CategoryAdminController@destroy']);
	});
});
