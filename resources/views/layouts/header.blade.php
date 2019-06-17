<!-- Navigation -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="{{asset('bower_components/jquery/dist/jquery.js')}}"></script>
{{-- 모달창  --}}
<script src="{{ asset('js/jquery/jquery.modal.min.1.js') }}" defer></script>
{{-- 모달창 css  --}}
<link href="{{ asset('css/jquery.modal.min.1.css') }}" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}" style="font-size:30px; color:#a1c45a">Writing room</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" id ="inv_btn" href="#invite" rel="modal:open" style="color:#45b4e6">INVITE USER</a>
                    <a class="nav-link" id="inv_btn" href="{{url('/loadSearchModal')}}" rel="modal1:open" style="color:#45b4e6;border:0;background:transparent;">SEARCH USER</a>
                </li> -->
                <li class="nav-item">
                    <button class="nav-link" onclick="location.href='{{url('/graph')}}'" style="font-size:25px;  border:0; font-weight: 800;color:#a1c45a;background:transparent;">Revenue graph</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" href="#" style="font-size:25px;  border:0; font-weight: 800;color:#a1c45a;background:transparent;">Chatting</button>
                </li>
                @if(Auth::check()) {{-- 로그인 되어 있을 때 --}}
                <li class="nav-item">
                <form method="post" action="{{route('logout')}}" id='logout_btn' name="logout">
                    @csrf
                        <button class="nav-link" href="javascript:logout.submit();" style="font-size:25px; color:#a1c45a; border:0; font-weight: 800;background:transparent;">Logout</a></button>
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
