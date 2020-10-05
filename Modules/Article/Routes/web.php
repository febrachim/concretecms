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
	Route::group(['prefix'=>'article','as'=>'admin.article.', 'middleware' => ['role:superadministrator|administrator']], function(){
		Route::get('/', ['as' => 'index', 'uses' => 'ArticleAdminController@index']);
		Route::get('/{id}/details', ['as' => 'show', 'uses' => 'ArticleAdminController@show']);
		Route::get('/articles-by-category/{id}', ['as' => 'category', 'uses' => 'ArticleAdminController@showArticleByCategory']);
		Route::get('/create', ['as' => 'create', 'uses' => 'ArticleAdminController@create']);
		Route::post('', ['as' => 'store', 'uses' => 'ArticleAdminController@store']);
		Route::get('/delete/{id}', ['as' => 'delete', 'uses' => 'ArticleAdminController@destroy']);
	});
});
