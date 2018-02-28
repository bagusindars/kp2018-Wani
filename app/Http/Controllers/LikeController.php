<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Like;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($type,$model_id)
    {
    	if($type == 1){
    		$model_type = 'App\Models\Post';
    		$model = Post::find($model_id);
    	}

    	if($model->is_liked() == null){

            if(Auth::user()){
            	Like::create([
            		'user_id' => Auth::user()->id,
            		'likeable_id' => $model_id,
            		'likeable_type' => $model_type,
            	]);
            }

            if($post->user->id != Auth::user()->id){
                Notification::create([
                    'user_id' => $post->user->id,
                    'post_id' => $id,
                    'subject' => Auth::user()->name.' Menyukai post ',
                ]);
            }
	    }
    }

     public function unlike($type,$model_id)
    {
    	if($type == 1){
    		$model_type = 'App\Models\Post';
    		$model = Post::find($model_id);
    	}

    	if($model->is_liked()){
	    	Like::where('user_id', Auth::user()->id)
	    		->where('likeable_id',$model_id)
	    		->where('likeable_type',$model_type)
	    		->delete();
	    }
    }


    
}
