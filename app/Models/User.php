<?php

namespace App\Models;

use Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'email', 'password','job','quote','avatar','approve',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts(){
        return $this->hasMany('App\Models\Post');
    }
  
     public function comments(){
        return $this->hasMany('App\Models\Postcomment');
    }
   
    public function notifications(){
        return $this->hasMany('App\Models\Notification');
    } 
    public function likes(){
        return $this->morphMany('App\Models\Like','likeable');
    }


}
