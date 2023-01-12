<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function index()
    {
    return view('chat');
    }

    //Fetch Messages
    // public function fetchMessages()
    // {
    //     $messages = Message::with('user')->get();
    //     return view('welcome', compact('messages'));
    // }

    //Send Messages
//     public function sendMessage(Request $request)
// {
//   $user = Auth::user();

//   $message = $user->messages()->create([
//     'message' => $request->input('message')
//   ]);

//   broadcast(new MessageSent($user, $message))->toOthers();

//   return ['status' => 'Message Sent!'];
// }

}
