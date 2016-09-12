<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    
    protected $fillable = [
        'body',
    ];
    
    public function cards(){
        return $this->belongsTo('App\Card');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
}
