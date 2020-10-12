<?php

namespace Modules\ProductCategory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductCategory extends Model
{
    protected $fillable = [
    	'name',
    ];

    public function products() {
    	return $this->belongsToMany('Modules\Product\Entities\Product')
    		->using('App\ProductProductCategory');
    }
}
