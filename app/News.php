<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class News extends Model
{
  protected $table = 'news';
  
  protected $fillable = [
    'title',
    'body',
    'slug',
    'published',
    'important',
    'author_id',
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
  
  public function tag(){
    return $this->belongsToMany('App\Tag', 'news_tags')->withTimestamps();
  }
  
  public function tags_id(){
    
    $tags = $this->belongsToMany('App\Tag', 'news_tags')->withTimestamps();
    $ids = [];
    if(!empty($tags)){
      dd($tags->toArray());
      foreach ($tags as $tag){
        $ids[] = $tag->id;
      }
    }
    
    return $ids;
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
