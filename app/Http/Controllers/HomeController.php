<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function markasread($id)
    {
        if($id){
            auth()->user()->unreadNotifications->where('id',$id)->markAsRead();
        }
        return redirect()->back();
        // dd($notification);
        // return view('home');
    }
}
