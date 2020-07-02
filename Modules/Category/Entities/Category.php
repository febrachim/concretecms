<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Category extends Model
{
    protected $fillable = [
    	'name',
    	'slug'
    ];

    public function Articles() {
    	return $this->belongsToMany('Modules\Article\Entities\Article')
    		->using('App\ArticleCategory');
    }
}
