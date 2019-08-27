<!-- Navigation -->
<script src="{{asset('bower_components/jquery/dist/jquery.js')}}"></script>
<script src="{{ asset('js/jquery/jquery.modal.min.1.js') }}" defer></script>
<link href="{{ asset('css/jquery.modal.min.1.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" style="height:75px; background-color:white; box-shadow: 0px 0px 8px 5px lightgray; opacity: 0.7;">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('image/logo_book.png')}}" style="margin-right:20px;"><img src="{{asset('image/writing_room_sm.png')}}"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button class="nav-link" onclick="location.href='{{url('/graph')}}'" style="border:0; margin-right:60px; background:transparent;"><img src="{{asset('image/revenue.png')}}"></button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" href="#" style="border:0; margin-right:60px; background:transparent;"><img src="{{asset('image/chatting.png')}}"></button>
                </li>
                @if(Auth::check()) {{-- 로그인 되어 있을 때 --}}
                <li class="nav-item">
                <form method="post" action="{{route('logout')}}" id='logout_btn' name="logout">
                    @csrf
                        <button class="nav-link" href="javascript:logout.submit();" style="border:0; margin-right:20px; background:transparent;"><img src="{{asset('image/logout.png')}}"></a></button>
                </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{url('login')}}" style="color:#a1c45a">Login</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="search" class="modal" role="dialog">

</div>
