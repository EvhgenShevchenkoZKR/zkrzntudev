<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    
    protected $fillable = [
      'title', 'body', 'image',
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function notes(){
        return $this->hasMany('App\Note');
    }

    public function addNote(Note $note, $userId) {
        $note->user_id = $userId;
        return $this->notes()->save($note);
    }
}
