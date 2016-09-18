<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ChildPage extends Model
{
  protected $table = 'child_pages';
  
  protected $fillable = [
    'title',
    'body',
    'slug',
    'published',
    'parent_id',
    'user_id',
    'cover_image',
    'cover_show',
    'cover_title',
    'cover_alt',
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
  
  public function author(){
    return $this->belongsTo('\App\User');
  }
  
  public function parent(){
    return $this->belongsTo('App\ParentPage');
  }

  public function getRelatedNews(){
    $tags = $this->parent->tag()->get();
    $relatedNews = [];
    foreach ($tags as $tag){
      $related = $tag->news()->get();
      foreach ($related as $rel){
          $relatedNews[$rel->id] = $rel;
      }
    }
    return $relatedNews;
  }
}
