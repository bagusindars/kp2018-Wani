<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable =[
		'title','slug','featured_img','content','user_id','approve',
	];


    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
    public function isOwner(){
    	if(Auth::guest())
    		return false;
    	
    	return Auth::user()->id == $this->user_id;
    }
    public function admin(){
        return Auth::user()->role == '1';
    }

    public function comments(){
        return $this->hasMany('App\Models\Postcomment');
    }
   
    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }

    public function likes(){
        return $this->morphMany('App\Models\Like','likeable');
    }
    public function is_liked(){
        if(Auth::guest())
            return false;

        return $this->likes->where('user_id', Auth::user()->id)->count();
    }
   
}
