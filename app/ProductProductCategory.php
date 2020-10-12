<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Product\Entities\Product;
use Modules\ProductCategory\Entities\ProductCategory;

class ProductProductCategory extends Pivot
{
    public function product() {
        return $this->belongsTo('Product');
    }

    public function productCategory() {
        return $this->belongsTo('ProductCategory');
    }
}
