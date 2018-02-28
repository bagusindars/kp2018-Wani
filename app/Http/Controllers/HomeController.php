<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Notification;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/home');
    }

    
    public function get_notif(){
        $user = Auth::user();
        $notifications = Notification::where('user_id', $user->id )->orderBy('id','desc')->get();
        $notif_model = new Notification;
        return view('notif', compact('notifications','notif_model','user'));
    }
  
    public function delete_notif($id){
        Notification::where('user_id',Auth::user()->id)->delete();
        return redirect('/notifications');
    }
}
