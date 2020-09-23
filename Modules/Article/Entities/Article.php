<?php

namespace Modules\Article\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Article extends Model implements HasMedia
{
    use HasMediaTrait;

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

    // public function registerMediaCollections() {
    //     $this->addMediaCollection('article-banner')
    //         ->acceptsMimeTypes(['image/jpeg', 'image/png'])
    //         ->registerMediaConversions(function (Media $media) {
    //             $this
    //                 ->addMediaConversion('thumb')
    //                 ->width(400)
    //                 ->height(300);
    //         });
    // }
}
