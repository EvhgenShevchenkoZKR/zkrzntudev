<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';  
  
    protected $fillable = [
      'body',
      'author',
      'user_id'
    ];
  
    public function author(){
      return $this->belongsTo('App\User');
    }
    
}
