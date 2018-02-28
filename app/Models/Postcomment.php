<?php

namespace App\Models;
use Auth; 
use Illuminate\Database\Eloquent\Model;

class Postcomment extends Model
{
	protected $fillable = ['subject','user_id','post_id'];
    public function user(){
    	return $this->belongsTo('App\Models\User');
    }
    public function post(){
    	return $this->belongsTo('App\Models\Post');
    }

 	public function isOwner(){
		if(Auth::guest())
			return false;
		
		return Auth::user()->id == $this->user_id;
    }

}
