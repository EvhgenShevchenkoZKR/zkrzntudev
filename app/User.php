<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cards(){
        return $this->hasMany('App\Card');
    }
    
    public function notes(){
        return $this->hasMany('App\Note');
    }
    
    public function quotes(){
        return $this->hasMany('\App\Quote');
    }
    
    public function adverts(){
        return $this->hasMany('\App\Advert');
    }
    
    public function employees(){
        return $this->hasMany('\App\Employee');
    }
    
    public function links(){
        return $this->hasMany('\App\Link');
    }
    
    public function massonry(){
        return $this->hasMany('\App\Massonry');
    }
    
    public function parentPages(){
        return $this->hasMany('\App\ParentPage');
    }
    
}
