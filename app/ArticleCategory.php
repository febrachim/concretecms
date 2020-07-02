<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Article\Entities\Article;
use Modules\Category\Entities\Category;

class ArticleCategory extends Pivot
{
    public function article() {
        return $this->belongsTo('Article');
    }

    public function category() {
        return $this->belongsTo('Category');
    }
}
