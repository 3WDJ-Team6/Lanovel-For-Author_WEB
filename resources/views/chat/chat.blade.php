<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>
    <div class="container">
        <div class="row" id="app">
            <div class=" offset-4 col-4 offset-sm-1 col-sm-10" style='margin:0;padding:0;'>
                    <li class="list-group-item active">Chat Room<div class="badge badge-pill badge-warning">@{{numberOfUser}}</div>
                    </li>
                    <ul class="list-group" v-chat-scroll style="background-color: white;">
                            @foreach ($content_of_chat as $row)
                                <div>
                                    <small id="usernickname" class="badge float-left">{{$row['nickname']}}</small>
                                    <li id="chatContent"class="list-group-item list-group-item-success">{{$row['content_of_chat']}}</li>
                                    <mark class="badge float-right" id="time">{{$row['created_at']}}</mark>
                                </div>
                            @endforeach
                            <message
                            v-for="(value,index) in chat.message"
                            :key = value.index
                            :color = chat.color[index]
                            :user = chat.user[index]
                            :time = chat.time[index]
                        >
                        @{{value}}
                        </message>
                    </ul>
                    <div class="badge badge-primary">@{{typing}}</div>
                    <input type="text" class="form-control" placeholder="Type your message here"
                    v-model='message' @keyup.enter='send'>
            </div>
        </div>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
