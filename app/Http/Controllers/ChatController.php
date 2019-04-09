<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatRoom;

class ChatController extends Controller
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

    public function chat()
    {
        $content_of_chat = User::select(
            'users.nickname',
            'chat_rooms.content_of_chat',
            'chat_rooms.created_at'
        )->join('chat_rooms','chat_rooms.user_id','users.id')
        ->orderBy('created_at','asc')
        ->where('chat_rooms.num_of_work','=',1)
        ->get();
        return view('chat/chat')->with('content_of_chat',$content_of_chat);
    }

    public function send(request $request){
     $user = User::find(Auth::id());
     $messages = $request->get('message');
     $chat = new ChatRoom();
     $chat->num_of_work = 1;
     $chat->content_of_chat = $messages;
     $chat->user_id = Auth::id();
     $chat->save();
     event(new ChatEvent($messages,$user));

     return $request->all();
    }
}
