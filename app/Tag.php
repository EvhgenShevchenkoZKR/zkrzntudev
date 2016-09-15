<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{
  protected $table = 'tags';

  protected $fillable = [
    'title',
    'meta_title',
    'meta_keywords',
    'meta_description',
  ];

  use Sluggable;

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }

  public function news(){
    return $this->belongsToMany('App\News', 'news_tags')->withTimestamps();
  }

  public function parentPages(){
    return $this->belongsToMany('App\ParentPage', 'parent_tags')->withTimestamps();
  }
}
