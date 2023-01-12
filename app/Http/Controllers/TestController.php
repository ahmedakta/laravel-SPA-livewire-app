<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Test;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class TestController extends Controller
{

    public function sendNotification()
    {
        $user = User::first();
        $data=[
            'text' => 'hi',
            'content' => 'example notification',
            'url' => url('/'),
            'thankyou' => 'Thank You For Use Our Application.. Ahmed'
        ];
        $user->notify(new Test($user));
        // Notification::send($user, new Test($data));
    }
}
