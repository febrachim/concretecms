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

Route::prefix('product')->group(function() {
    Route::get('/', 'ProductController@index');
});

Route::prefix('backoffice')->group(function() {
	Route::group(['prefix'=>'product','as'=>'admin.product.', 'middleware' => ['role:superadministrator|administrator']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'ProductAdminController@index']);
		Route::get('/{id}/details', ['as' => 'show', 'uses' => 'ProductAdminController@show']);
		Route::get('/create', ['as' => 'create', 'uses' => 'ProductAdminController@create']);
		Route::post('', ['as' => 'store', 'uses' => 'ProductAdminController@store']);
		Route::get('/{id}/edit/', ['as' => 'edit', 'uses' => 'ProductAdminController@edit']);
		Route::match(['put', 'patch'], '/{id}/update', ['as' => 'update', 'uses' => 'ProductAdminController@update']);
		Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'ProductAdminController@destroy']);
		Route::post('/upload', ['as' => 'upload', 'uses' => 'ProductAdminController@imageUpload']);
	});
});
