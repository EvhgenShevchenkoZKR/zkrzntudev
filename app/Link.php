<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
  protected $fillable = [
    'title',
    'url',
    'image',
    'image_alt',
    'image_title',
    'published',
    'weight',
    'user_id',
  ];

  protected $table = 'links';

  public function user(){
    return $this->belongsTo('\App\User');
  }
}
