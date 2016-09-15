<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ParentPage extends Model
{
  protected $table = 'parents';
  
  protected $fillable = [
    'title',
    'title_children',
    'title_tags',
    'description',
    'slug',
    'published',
    'author_id',
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
  
  public function tag(){
    return $this->belongsToMany('App\Tag', 'parent_tags')->withTimestamps();
  }

  public function children(){
    return $this->hasMany('App\ChildPage', 'parent_id');
  }
  
  public function getRelatedNews(){
    $tags = $this->tag()->get();
    $relatedNews = [];
    foreach ($tags as $tag){
      $related = $tag->news()->get();
      foreach ($related as $rel){
        $relatedNews[] = $rel;
      }
    }
    return $relatedNews;
  }
}
