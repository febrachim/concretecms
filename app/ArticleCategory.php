<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;

class ArticleCategory extends Pivot
{
    // public function article() {
    //     return $this->belongsTo('Article');
    // }

    // public function category() {
    //     return $this->belongsTo('Category');
    // }

    // Note: Adding relationships to a pivot model means
    // you'll probably want a primary key on the pivot table.
    public function articles($value) {
        return $this->hasMany('Article'); // example relationship on a pivot model
    }

    // Note: Adding relationships to a pivot model means
    // you'll probably want a primary key on the pivot table.
    public function categories($value) {
        return $this->hasMany('Category'); // example relationship on a pivot model
    }
}
