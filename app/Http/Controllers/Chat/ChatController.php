<?php

namespace App\Http\Controllers\Chat;

// use App\Events\ChatEvent;
use App\Models\ChatRoom; # Message Model
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ContentOfWork;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Broadcast;

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
        $pageurl = url()->previous();
        $num = str::after($pageurl, 'editor/');

        $num_of_work = ContentOfWork::select(
            'content_of_works.num_of_work'
        )->where('content_of_works.num', '=', $num)
            ->get();
        $num = str::after($num_of_work, ':');
        $num_of_work = str::before($num, '}');

        $content_of_chat = User::select(
            'users.nickname',
            'chat_rooms.content_of_chat',
            'chat_rooms.created_at'
        )->join('chat_rooms', 'chat_rooms.user_id', 'users.id')
            ->orderBy('created_at', 'asc')
            ->where('chat_rooms.num_of_work', '=', $num_of_work)
            ->get();

        return view('chat/chat')->with('content_of_chat', $content_of_chat);
    }

    public function getChat()
    {
        return 0;
        $content_of_chat = User::select(
            'users.nickname',
            'chat_rooms.content_of_chat',
            'chat_rooms.created_at'
        )->join('chat_rooms', 'chat_rooms.user_id', 'users.id')
            ->orderBy('created_at', 'asc')
            ->where('chat_rooms.num_of_work', '=', $num_of_work)
            ->get();
    }

    public function messageSend(request $request)
    {
        $pageurl = url()->previous();
        $num = str::after($pageurl, 'editor/');

        $num_of_work = ContentOfWork::select(
            'content_of_works.num_of_work'
        )->where('content_of_works.num', '=', $num)
            ->get();

        $num = str::after($num_of_work, ':');
        $num_of_work = str::before($num, '}');

        $user = User::find(Auth::id());
        $messages = $request->get('message');

        $chat = new ChatRoom(); //DB에 저장 후 event발생
        $chat->num_of_work = $num_of_work;
        $chat->content_of_chat = $messages;
        $chat->user_id = Auth::id();
        $chat->save();

        Broadcast(new \App\Events\ChatEvent($messages, $user));

        return response()->json($request->all(), 200);
    }

    // public function send(request $request)
    // {
    //     $pageurl = url()->previous();
    //     $num = str::after($pageurl, 'editor/');

    //     $num_of_work = ContentOfWork::select(
    //         'content_of_works.num_of_work'
    //     )->where('content_of_works.num', '=', $num)
    //         ->get();

    //     $num = str::after($num_of_work, ':');
    //     $num_of_work = str::before($num, '}');
    //     $user = User::find(Auth::id());
    //     $messages = $request->get('message');
    //     $chat = new ChatRoom();
    //     $chat->num_of_work = $num_of_work;
    //     $chat->content_of_chat = $messages;
    //     $chat->user_id = Auth::id();
    //     $chat->save();

    //     event(new ChatEvent($messages, $user));

    //     return response()->json($request->all(), 200);
    // }
}
