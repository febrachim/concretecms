<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [];

    public function Categories() {
    	return $this->belongsToMany('Modules\Category\Entities\Category');
    }
}
