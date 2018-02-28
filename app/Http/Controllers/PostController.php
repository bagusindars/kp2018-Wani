<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Postcomment;
use App\Models\Tag;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function halamanawal(){
          $posts = Post::with('tags')->where('approve','1')->orderBy('created_at','desc')->get();
        return view('welcome',compact('posts'));
    }


    public function index(Request $request)
    {
       $search_q = urlencode($request->input('search'));
       $users = new User;
        $tags = Tag::all();

        if(!empty($search_q)){
            $posts= Post::with('tags')->where('title','like','%'.$search_q.'%')->orderBy('created_at','desc')->get();
          
        }
        else
            $posts = Post::with('tags')->where('approve','1')->orderBy('created_at','desc')->get();
            // $postadmin = Post::with('tags')->orderBy('created_at','desc')->limit(5)->get();
            $postadmin = Post::with('tags')->whereHas('tags',function($query){
                $query->where('name',"Kabar Admin");
            })->orderBy('created_at','desc')->limit(5)->get();
            
        return view('posts.index', compact('posts','users','postadmin'));
    }

    public function allpost(){
          $posts = Post::with('tags')->where('approve','1')->orderBy('created_at','desc')->paginate(24);
         return view('posts.allpost',compact('posts')); 
    }

    public function allposttype($type){
        $user = User::all();
        if(request()->path($type) == 'posts/all/nandadmin'  ){
    
            $posts = Post::with('tags')->where('approve','1')->whereHas('user',function($query){
                $query->where('role','0');
            })->orderBy('created_at','desc')->paginate(24);
        }elseif(request()->path($type) == 'posts/all/admin' ){
     
            $posts = Post::with('tags')->where('approve','1')->whereHas('user',function($query){
                $query->where('role','1');
            })->orderBy('created_at','desc')->paginate(24);
        }

        else{
            return redirect('posts/all');
        }
        return view('posts.allpost',compact('posts'));
        
    }

    public function search(Request $request){

        $tags = Tag::all();
        $user = User::all();
        $cari = urlencode($request->input('search'));
        $cari_post = new Post;
        $hasil = str_replace("+", " " , $cari);
           $users = User::where('approve','1')->orderBy('id','asc')->paginate(13); 
        if(!empty($cari)){
            $posts = Post::with('tags')->where('title','like','%'.$hasil.'%')
                            ->where('approve','1')
                            ->orWhere('content','like','%'.$hasil.'%')
                            ->where('approve','1')
                            ->orWhereHas('tags',function($query) use ($hasil){
                                    $query->where('name','like','%'.$hasil.'%');
                                })
                            ->where('approve','1')
                            ->orWhereHas('user',function($query) use ($hasil){
                                    $query->where('name','like','%'.$hasil.'%');
                                })
                            ->where('approve','1')
                            ->orWhere(function($query) use($hasil){
                                $query->when('tag != null', function($q) use ($hasil){
                                    $q->where('tag','like','%'.$hasil.'%');
                                });
                            })
                            ->where('approve','1')
                            ->orderBy('created_at','desc')
                            ->paginate(13);

            $users = User::where('name','like','%'.$hasil.'%')
                            ->where('approve','1')
                            ->orWhere('username','like','%'.$hasil.'%')
                            ->where('approve','1')

                            ->paginate(21);

           
            }
        else
       
        $posts = Post::with('tags')->where('approve','1')->orderBy('created_at','desc')->paginate(21);
       return view('posts.search',compact('posts','tags','search','users'));
    }

    public function filtershow($tag){
        $tags = Tag::all();
        $posts = Post::with('tags')->where('approve','1')->whereHas('tags',function($query) use ($tag){
            $query->where('name',$tag);
        })->orderBy('created_at','desc')->paginate(24);
       
  
        if(request()->segment(3) == "Lain-lain"){
             $posts = Post::where('approve',1)->where('tag','!=',null)->orderBy('created_at','desc')->paginate(24);
        }
        return view('posts.allpost',compact('posts','tags'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()){
            if(Auth::user()->role == '0')
                $tags = Tag::where('name','!=','Kabar Admin')->get();
            else
                $tags = Tag::all();
            return view('posts.create',compact('tags'));
        }
        else
            return redirect('/posts');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       
        $this->validate($request,[
            'title' => 'required|min:1',
            'content' => 'required|min:1',
        ]);
        $slug = str_slug($request->title.'-');

        if(Post::where('slug',$slug)->first() != null)
            $slug = $slug.'-'.time();

        $filename = $slug;
        $img = array();
        if($request->file('featured_img') == null)
             return redirect('posts/create')->with('error_img','Gambar tidak boleh kosong');

        else if ($request->hasFile('featured_img')) {

            $files = $request->file('featured_img');
            
            

            foreach($files as $file){
                $filenames = $file->getClientOriginalName();
                $filenames = $string = preg_replace('/\s+/', '', $filenames);
                $extension = $file->getClientOriginalExtension();
                $picture = date('His').$filenames;
                $destinationPath = public_path('storage/gambar_post');
                $file->move($destinationPath, $picture);
                $img[] = $picture;
            }

        }

        if(Auth::user()->role == '1'){
            $post = Post::create([
                'title' => $request->title,
                'slug' => $slug,
                'featured_img' => implode(' ',$img),
                'content' => $request->content,
                'approve' => '1',
                'user_id' => Auth::user()->id
            ]);
        }else{
            $post = Post::create([
                'title' => $request->title,
                'slug' => $slug,
                'featured_img' => implode(' ',$img),
                'content' => $request->content,
                'user_id' => Auth::user()->id
            ]);
        }
        


      
        if(!empty($request->tags)){
             $post->tags()->attach($request->tags);
        }elseif(!empty($request->tag_bebas)){
            $post->tag = $request->tag_bebas;
            $post->save();
        }
     
        return redirect('/posts/'.$slug)->with('pesan','Mading berhasil di buat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $posts = Post::with('comments.user')->where('slug',$slug)
                                           ->first();

        $user = Auth::user();
        if(empty($posts)) abort(404);
        
        if($posts->approve == '0'){
            if(Auth::guest() || ($user->id != $posts->user_id && $user->role == '0' ))
                return redirect()->back();
            elseif($posts->isOwner() || $user->role == '1')
                return view('posts.single',compact('posts'));
        }
        
        return view('posts.single',compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $posts = Post::findOrFail($id);
        if(Auth::user()->role == '0')
            $tags = Tag::where('name','!=','Kabar Admin')->get();
        else
            $tags = Tag::all();

        foreach ($posts->tags as $tagmilik) {
            $tagmilik = $tagmilik->id;
        }
        


        return view('posts.edit',compact('posts','tags','tagmilik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'title' => 'required|min:1',
            // 'featured_img' => 'mimes:jpeg,bmp,png,jpg',
        ]);

         $files = $request->file('featured_img');
        $img = array();
        $posts = Post::find($id);
        $images = $posts->featured_img;
        $fiximglama = explode(" ", $images);
        $start = 0;

        for ($i=0; $i <= count($fiximglama) ; $i++) { 
            # code...
            if(isset($_POST['delete_'.$i]) && !empty($_POST['delete_'.$i])){
                unset($fiximglama[$i]);
                $urut = array_values($fiximglama);
                $urutaray = implode(" ",$urut);
                if(Auth::user()){
                    $posts->update([
                        'title' => $request->title,
                        'content' => $request->content,
                        'featured_img' => $urutaray,
                        'approve' => '0',
                    ]);
                }else{
                    $posts->update([
                        'title' => $request->title,
                        'content' => $request->content,
                        'featured_img' => $urutaray,
                        'approve' => '1',
                    ]);
                }
                return redirect()->back();
            }
        }
        switch ($request->submitedit) {

            case 'Delete':              
                   return redirect()->back();
                break;
            
            case 'Edit':
              
               

                if($request->file('featured_img') != null ){

                     foreach($files as $file){
                        $filenames = $file->getClientOriginalName();
                        $filenames = $string = preg_replace('/\s+/', '', $filenames);
                        $extension = $file->getClientOriginalExtension();
                        $picture = date('His').$filenames;
                        $destinationPath = public_path('storage/gambar_post');
                        $file->move($destinationPath, $picture);
                        $img[] = $picture;

                    }
                    
                     if($posts->isOwner())
                        if(Auth::user()->role == '0'){
                            $posts->update([

                                'title' => $request->title,
                                'featured_img' => implode(' ',$img) ." ".implode(" ",$fiximglama),
                                'content' => $request->content,
                                'approve' => '0',

                            ]);
                        }else{
                             $posts->update([

                                'title' => $request->title,
                                'featured_img' => implode(' ',$img) ." ".implode(" ",$fiximglama),
                                'content' => $request->content,
                                'approve' => '1',

                            ]);
                        }
                     else abort(404);
                }

                else if($request->file('featured_img') == null ){
                    if($posts->isOwner()){

                        if(Auth::user()->role == '0'){
                            $posts->update([
                            'title' => $request->title,
                            'content' => $request->content,
                            'approve' => '0',
                            ]);

                        }else{
                            $posts->update([
                                'title' => $request->title,
                                'content' => $request->content,
                                'approve' => '1',
                            ]);
                        }
                    }
                     else abort(404);
                }
                if(!empty($request->tags)){
                     $posts->tags()->sync($request->tags);
                     $posts->tag = null;
                     $posts->save();
                }elseif(!empty($request->tag_bebas)){
                    $posts->tags()->detach();
                    $posts->tag = $request->tag_bebas;
                    $posts->save();
                }
             
                
                return redirect('posts/'.$posts->slug)->with('pesan','Karya berhasil di update');

                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        $tags = Tag::find($id);
        if($posts->isOwner() || Auth::user()->role == '1'){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('posts')->where('id', $id)->delete();
            DB::table('postcomments')->where('post_id', $id)->delete();
            DB::table('post_tag')->where('post_id',$id)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                    }   
        else abort(404);
        return redirect('/posts')->with('pesan','Karya berhasil di hapus');
    }


    public function managepostbyadmin(Request $request){
        if(Auth::user()->role == '0' || Auth::guest() )
            return redirect('/posts');
        $user = new User;
        $post = Post::orderBy('id','ASC')->where('approve','1')->get();

        $cari = urlencode($request->input('search'));
        $cari_post = new Post;
        $hasil = str_replace("+", " " , $cari);
        
        if(!empty($cari)){
            $post = Post::where('title','like','%'.$hasil.'%')
                            ->where('approve','1')
                            ->get()->except('approve','0');
        }
        else
            $post = Post::where('approve', '1')->orderBy('id','ASC')->get();
        
        return view('managepost', compact('post'));
    }

    public function managepostdeletebyadmin($id){
        $post = Post::findOrFail($id);

        if(Auth::user()->role == '0' || Auth::guest())
            return redirect('/posts');
        

        if($post->approve != '1'){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('posts')->where('id', $id)->delete();
            DB::table('post_tag')->where('post_id', $id)->delete();
            DB::table('notifications')->where('post_id', $id)->delete();
            DB::table('postcomments')->where('post_id', $id)->delete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } 
        
        else abort(404);
        
        return redirect('/profile');
    }


    public function confirmationpost(Request $request){
        if(Auth::user()->role == '0' || Auth::guest() )
            return redirect('/posts');
        $cari = urlencode($request->input('search'));
        $cari_user = new User;
        $hasil = str_replace("+", " " , $cari);
        if(!empty($cari)){
            $post = Post::where('title','like','%'.$hasil.'%')->where("approve",'0')
                    
                        ->get()->except("approve",'1');
        }

        else
            $post = Post::where('approve', '0')->orderBy('id','ASC')->get();

        return view('confirmpost', compact('post'));
    }
    public function confirmationpostconfirm($id){

       $post = Post::findOrFail($id);
       if(!is_null($post)){
            $post->update([
            'approve' => '1',
        ]);
       
        return redirect('/confirmationpost')->with('pesan','Berhasil konfirmasi post');
       }
        
    }
}

