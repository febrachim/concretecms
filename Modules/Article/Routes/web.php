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

Route::prefix('article')->group(function() {
    Route::get('/', 'ArticleController@index')->name('article');
});

Route::prefix('backoffice')->group(function() {
	Route::group(['prefix'=>'article','as'=>'admin.article.', 'middleware' => ['role:super-admin|admin|editor']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'ArticleAdminController@index']);
		Route::get('/create', ['as' => 'create', 'uses' => 'ArticleAdminController@create']);
		Route::post('', ['as' => 'store', 'uses' => 'ArticleAdminController@store']);
	});
});
