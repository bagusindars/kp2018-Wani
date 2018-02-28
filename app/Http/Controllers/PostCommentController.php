<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Notification;
use App\Models\Postcomment;


class PostCommentController extends Controller
{
    
    public function store(Request $request,$id)
    {

        $this->validate($request,[
            'subject' => 'required|min:1',
        ]);
        $post = Post::findOrFail($id);
      
        $postcomment = Postcomment::create([
            'subject' => $request->subject,
            'post_id' => $id,
            'user_id' => Auth::user()->id
        ]);

        if($post->user->id != Auth::user()->id){
            Notification::create([
                'user_id' => $post->user->id,
                'post_id' => $id,
                'subject' => 'Ada komentar dari '.Auth::user()->name,
            ]);
        }
        return redirect('/posts/'.$postcomment->post->slug);

    }

   
    public function edit($id)
    {
        $comment = Postcomment::findOrFail($id);
        return view('post-comments.edit',compact('comment'));
    }

  
    public function update(Request $request, $id)
    {
        $comment = Postcomment::findOrFail($id);

        if($comment->isOwner())
            $comment->update([
                'subject' => $request->subject,
            ]);
        else abort(404);
        return redirect('/posts/'.$comment->post->slug);
    }

 
    public function destroy($id)
    {
        $comment = Postcomment::findOrFail($id);
        if($comment->isOwner() ||  Auth::user()->role = '1')
            $comment->delete();
        else abort(404);
        return redirect('/posts/'.$comment->post->slug);
    }


}
