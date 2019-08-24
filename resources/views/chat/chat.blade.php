<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <style>
        .body-chat {
            padding-bottom: 0;
        }

        .chat-header,
        .chat-header a {
            background-color: #a1c0d6;
            color: black;
        }

        .chat-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .chat {
            background-color: #a1c0d6;
            height: 150vh;
            padding-top: 15px;
            padding-left: 5px;
            padding-right: 5px;
        }

        .chat .date-divider {
            text-align: center;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.5);
            margin-bottom: 15px;
        }

        .chat__message {
            margin-bottom: 10px;
            display: flex;
            align-items: flex-end;
        }

        .chat__message-from-me {
            justify-content: flex-end;
            float: right;
            /* css end -> start*/
        }
        .chat__message-date-me {
            padding-top: 15%
        }
        .chat__message-date {
            padding-top: 11%
        }

        .chat__message--to-me .chat__message-avatar {
            align-self: flex-start;
        }

        .chat__message-time {
            font-size: 10px;
            color: rgba(0, 0, 0, 0.5);
        }

        .chat__message-from-me .chat__message-body {
            background-color: #ffe934;
            padding-left: 5px;
            margin-left: 5px;
        }

        .chat__message-body {
            padding: 10px 5px;
            border-radius: 5px;
            background-color: #ffffff;
            margin-right: 5px;
        }

        .chat__message--to-me .chat__message-avatar {
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat__message .chat__message-username {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .chat__message-center {
            display: flex;
            flex-direction: column;
        }

        .type-message {
            width: 100%;
            bottom: 54px;
            position: fixed;
            height: 45px;
            background: #eeeeee;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 10px;
            padding-right: 5px;
        }

        .type-message .fa-plus {
            color: #b4b4b4;
        }

        .type-message__input {
            width: 80%;
            display: flex;
            align-items: center;
            position: relative;
        }

        .type-message__input input {
            width: 100%;
            padding: 10px;
        }

        .type-message__input .fa-smile-o {
            position: absolute;
            right: 40px;
            color: #b4b4b4;
        }

        .type-message__input .record-message {
            color: #523737;
            background-color: #ffe934;
            padding: 10px;
            cursor: pointer;
        }
        .friend{
            display: block;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="row" id="app">
            <div class=" offset-4 col-4 offset-sm-1 col-sm-10" style='margin:0;padding:0;'>
                <li class="list-group-item active">Chatting Room
                    <div class="badge badge-pill badge-warning">@{{2}}</div>
                </li>
                <ul class="list-group" v-chat-scroll style="background-color: #a1c0d6;">
                    @foreach ($content_of_chat as $row)
                    <div>
                        @if($row['nickname'] == Auth::user()['nickname']) {{-- 내가 보낸 메세지 --}}
                        <li id="chatContent" class="list-group-item list-group-item-success chat__message-from-me">{{$row['content_of_chat']}}
                        </li>
                        <mark class="badge float-right chat__message-time chat__message-date-me" id="time">{{$row['created_at']->diffForHumans()}}</mark>
                        @else
                        <small id="usernickname" class="badge friend" font-size="10px">{{$row['nickname']}}</small>
                        <li id="chatContent" class="list-group-item float-left list-group-item-success chat__message-body">{{$row['content_of_chat']}}
                        </li>
                        <mark class="badge chat__message-time chat__message-date" id="time">{{$row['created_at']->diffForHumans()}}</mark>
                        @endif

                    </div>
                    @endforeach
                    <message v-for="(value,index) in chat.message" :key=value.index :color=chat.color[index] :user=chat.user[index] :time=chat.time[index]>
                        @{{value}}
                    </message>
                </ul>
                <div class="badge badge-primary">@{{typing}}</div>
                <input type="text" class="form-control" placeholder="Type your message here" v-model='message' @keyup.enter='send'>
            </div>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>
