<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;    
use Auth;
use Image;
use App\Models\User;
use App\Models\Tag;
use App\Models\Post;
    
class profilecontroller extends Controller
{
      public function profile($id = null){

       
        if($id == null){
        	if(Auth::guest()){
        		return redirect('/posts');
            }
            $user = User::findOrFail(Auth::user()->id);
            return view('profile.index',compact('user'));   

        }else
            $user = User::findOrFail($id);
        
        return view('profile.index',compact('user'));
      
    }
    public function profileedit($id){
        $user = User::findOrFail($id);
        return view('profile.edit',['user' => $user]);
    }

   

    public function update(Request $request,$id){
        $user = User::findOrFail($id);
        if(Auth::user() == $user ){

        	if($request->hasFile('avatar')){
				$avatar = $request->file('avatar');
				$filename = time().'.'.$avatar->getClientOriginalExtension();
				Image::make($avatar)->resize(300,300)->save(public_path('upload/avatars/'.$filename));
				$user->avatar = $filename;
				$user->save();
			}
            if(!empty($request->password)){

                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'job' => $request->job,
                    'password' => bcrypt($request->password),
                    'quote' => $request->quote,
                ]);

            }
            else{
                $user->update([
                        'name' => $request->name,
                        'username' => $request->username,
                        'email' => $request->email,
                        'job' => $request->job,
                        'quote' => $request->quote,
                ]);
             
            } 

              
        }
         else abort(404);
         return redirect('/profile');
    }

    public function admin(){
        $countmu = User::where('approve','=','1')->count();
        $countmp = Post::where('approve','=','1')->count();
        $countcu = User::where('approve','=','0')->count();
        $countcp = Post::where('approve','=','0')->count();
        if( Auth::guest() || Auth::user()->role == '0' )
            return redirect('/profile');
        else
            $user = User::findOrFail(Auth()->user()->id);
            return view('profile.admin',compact('user','countmu','countmp','countcu','countcp'));
    }


    public function manageuserbyadmin(Request $request){
        if(Auth::user()->role == '0' || Auth::guest() )
            return redirect('/posts');

        $cari = urlencode($request->input('search'));
        $cari_user = new User;
        $hasil = str_replace("+", " " , $cari);
        if(!empty($cari)){
            $user = User::where('username','like','%'.$hasil.'%')
                            ->orWhere('name','like','%'.$hasil.'%')
                            ->get()->except($cari_user->role = '1')->except('approve','0');
        }
        else
            $user = User::where('role', '0')->where('approve','1')->orderBy('id','ASC')->get();
        return view('manageuser', compact('user'));
    }


    public function manageuserdeletebyadmin($id){
        $user = User::findOrFail($id);

        if(Auth::user()->role == '0' || Auth::guest())
            return redirect('/posts');
        

        if($user->role != '1'){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('users')->where('id',$id)->delete();
            DB::table('posts')->where('user_id', $id)->delete();
            DB::table('notifications')->where('user_id', $id)->delete();
            DB::table('postcomments')->where('user_id', $id)->delete();
            DB::table('likes')->where('user_id',$id)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } 
        
        else abort(404);
        
        return redirect('/manageuser');
    }

    public function confirmationuser(Request $request){
        //

        if(Auth::user()->role == '0' || Auth::guest() )
            return redirect('/posts');
            
        $cari = urlencode($request->input('search'));
        $cari_user = new User;
        $hasil = str_replace("+", " " , $cari);
        if(!empty($cari)){
            $user = User::where('username','like','%'.$hasil.'%')->where("approve",'0')
                        ->orWhere("name",'like','%'.$hasil.'%')
                        ->where("approve",'0')
                        ->get()->except($cari_user->role = '1')->except($cari_user->approve,'1');
        }

        else
            $user = User::where('role', '0')->where('approve' , '0')->orderBy('id','ASC')->get();

        return view('confirmuser', compact('user'));
    }

    public function confirmationuserconfirm($id){
   
       $user = User::findOrFail($id);
       if(!is_null($user)){
            $user->update([
            'approve' => '1',
        ]);
       
        return redirect('/confirmationuser')->with('pesan','Berhasil konfirmasi user');
       }
        
    }


    public function lihattag(Request $request){
        if(Auth::user()->role == '0' || Auth::guest() )
            return redirect('/posts');
            
        $cari = urlencode($request->input('search'));
        $hasil = str_replace("+", " " , $cari);
        if(!empty($cari)){
            $tag = Tag::where('name','like','%'.$hasil.'%')->get();
        }else{
              $tag = Tag::orderBy('name','asc')->get();
        }
      
        return view('managetag',compact('tag'));
    }

    public function createtag(Request $request){
        if(Auth::user()->role == '0' || Auth::guest() )
        return redirect('/posts');
        
       $tag = new Tag;
       $tag->create([
            'name' => $request->namatag,
       ]);
     
       return redirect()->back()->with('berhasil','berhasil membuat tag '.$request->namatag);
    }

    public function showtag($id,Request $request){
        $tags = Tag::findOrFail($id);
        return view('edittag',compact('tags'));
    }

    public function edittag(Request  $request, $id){
        $tags = Tag::findOrFail($id);
        $taglama = $tags;
        $tags->update([
            'name' => $request->gantitag,
        ]);
        $tags->save();
        return redirect('/managetag')->with('pesan','berhasil edit tag : '.$taglama->name .' menjadi '.$request->gantitag );
    }

    public function hapustag($id){
        
        $tag = Tag::findOrFail($id);
        $p = Post::whereHas('tags',function($query) use ($id){
                $query->where('tags.id',$id);
            });

        $p->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('post_tag')->where('tag_id',$id)->delete();
            DB::table('tags')->where('id',$id)->delete();
           
        
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->back()->with('pesan','Berhasil hapus tag : '.$tag->name);
    }

}
