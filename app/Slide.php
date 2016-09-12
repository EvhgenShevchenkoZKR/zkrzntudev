<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
  protected $table = 'slides';
  
  protected $fillable = [
    'title', 'alt', 'image','slider_id'
  ];
  
  public function slider() {
    
    return $this->belongsTo('App\Slider');
  }
  
  public function getSlideByName($image, $id){
    $id = DB::table('slides')
      ->where('image', $image)
      ->where('slider_id', $id)
      ->lists('id');
    if(!$id){
      $id = $this->id;
    }
    else {
      $id = $id[0];
    }
    return $id;
  }
}
