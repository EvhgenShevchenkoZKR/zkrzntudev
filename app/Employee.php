<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
      'fio',
      'photo',
      'position',
      'body',
      'administration',
      'weight',
      'user_id',
    ];
  
  protected $table = 'employees';
  
  public function user(){
    return $this->belongsTo('\App\User');
  }
  
}
