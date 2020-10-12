<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Product extends Model
{
    protected $fillable = [
    	'name',
        'packaging',
        'composition',
        'overview',
        'instruction'
    ];

    public function productCategories() {
    	return $this->belongsToMany('Modules\ProductCategory\Entities\ProductCategory')
    		->using('App\ProductProductCategory');
    }
}
