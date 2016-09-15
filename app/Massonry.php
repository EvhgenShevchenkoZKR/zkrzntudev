<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Massonry extends Model
{
  protected $fillable = [
    'title',
    'body',
    'url',
    'image',
    'image_alt',
    'image_title',
    'published',
    'weight',
    'user_id',
  ];
  
  protected $table = 'massonries';
  
  public function user(){
    return $this->belongsTo('\App\User');
  }
}
