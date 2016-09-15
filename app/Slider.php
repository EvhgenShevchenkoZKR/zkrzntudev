<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
  
  protected $table = 'sliders';
  
  protected $fillable = [
    'title', 'url', 'weight', 'published'
  ];

  public function slides() {

    return $this->hasMany('App\Slide');
  }
  
}
