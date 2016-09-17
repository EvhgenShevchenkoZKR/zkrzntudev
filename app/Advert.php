<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Advert extends Model
{
    private $relatedLimit = 10; //limit of related objavas in block related
    protected $table = 'adverts';
  
    protected $fillable = [
      'title',
      'body',
      'slug',
      'author',
      'published',
      'user_id',
      'cover_image',
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
  
  public function user() {
    return $this->belongsTo('\App\User');
  }
  
  public function getRelatedNews(){
    $relatedNews = $this::select('*')
      ->where('published', true)
      ->Where('id', '<>', $this->id)
      ->orderBy('created_at', 'desc')
      ->limit($this->relatedLimit)
      ->get()->all();

    return $relatedNews;
  }
}
