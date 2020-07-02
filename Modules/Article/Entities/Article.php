<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Article extends Model
{
    protected $fillable = [
    	'author_id',
    	'title',
    	'slug',
    	'excerpt',
    	'content',
    	'status',
    	'type',
    	'banner',
    	'banner_mobile',
    	'comment_count',
    	'published_at'
    ];

    public function categories() {
    	return $this->belongsToMany('Modules\Category\Entities\Category')
    		->using('App\ArticleCategory');
    }

    public function author() {
  		return $this->belongsTo('App\User', 'author_id');
	}
}
