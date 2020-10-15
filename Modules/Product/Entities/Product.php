<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;

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
    
    public function registerMediaCollections() {
        $this->addMediaCollection('packshot')
        ->registerMediaConversions(function (Media $media) {
            $this
            ->addMediaConversion('thumb')
            ->width(480)
            ->sharpen(10);
        });
    }
}
