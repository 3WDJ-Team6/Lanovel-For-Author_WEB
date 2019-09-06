<header class="header_area">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{ asset('js/jquery/jquery.modal.min.1.js') }}" defer></script>
    <script src="{{ asset('js/invite_user.js') }}" defer></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link href="{{ asset('css/jquery.modal.min.1.css') }}" rel="stylesheet">
    <script>
        $(document).ready(function () {
            $(".closed").click(function () {
                $("#id01").hide();
            });
        });

    </script>
    <style>
        .holine {
            width: 94%;
            top: 32%;
            left: 4%;
            border: 1px solid #d8d8d8;
            margin: 0;
            margin-left: 3%;
            margin-bottom: 3%;
        }

        .logo {
            padding-bottom: 10px;
            width: 30px;
            height: 50px;
            margin-left: 4%;
            display: inline-block;
        }

        .btn_list {
            margin-left: 54%;
        }

        .list_title {
            padding-top: 2%;
        }

        .closed {
            width: 40px;
            height: 40px;
            display: inline-block;
            float: right;
            margin-right: 3%;
            cursor: pointer;
        }

        .modal-content {
            width: 120%;
            height: 230px;
        }

        .logo_moji {
            font-size: 30px;
            display: inline-block;
        }

        .bo {
            margin-left: 4%;
            font-size: 24px;
            margin-right: 6%;
            text-align: center;
            margin-top: 2%;
            margin-bottom: 5%;
            border: 2px solid #d8d8d8;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .search {
            width: 30px;
            height: 30px;
            position: absolute;
            top: 24.5%;
            right: 5%;
        }

        .form-control {
            background-color: rgb(247, 247, 247);
            border: 0;
            margin-left: 3%;
            margin-right: 3%;
            margin-bottom: 2%;
            width: 95%;
            font-size: 22px;
            font-weight: 800;
        }

        .message_head {
            margin-left: 3%;
        }

        .message_head_li {
            margin-right: 30%;
            font-weight: bold;
            font-size: 18px;
        }

        .message_box {
            width: 100%;
            height: 250px;
            overflow: scroll;
        }

        .message_box_ul {
            margin-left: 3%;
            margin-bottom: 2%;
        }

        .message_box_li {
            display: inline-block;
            margin-right: 7%;

        }

        .message_box_li_delete {
            float: right;
            margin-right: 3%;
            margin-top: -3%;
        }

    </style>
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <nav class="classy-navbar" id="essenceNav">
            <a class="nav-brand" href="{{ asset('/store') }}"><img src="{{asset('image/logo_book.png')}}"
                    style="margin-right:20px;"><img src="{{asset('image/store/illust_title_sm.png')}}"></a>
            <div class="classy-navbar-toggler">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <div class="classy-menu">
                <div class="classycloseIcon">
                    <div class="cross-wrap">
                        <span class="top"></span><span class="bottom"></span>
                    </div>
                </div>
                <div class="classynav">
                    <ul style="margin-top:6%;">
                        <li><a href="{{ url('menu/1') }}">Background</a></li>
                        <li><a href="{{ url('menu/2') }}">Character</a></li>
                        <li><a href="{{ url('menu/3') }}">Stoke</a></li>
                        <li><a href="{{ url('/illustCreate') }}">Upload</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="header-meta d-flex clearfix justify-content-end">

            <div class="search-area">
                <form action="#" method="post">
                    <input type="search" name="search" id="headerSearch" placeholder="Type for search" />
                    <button type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <form action="{{ url('store/find/search') }}" method="post">
                <button type="button submit" class="btn btn-light"
                    style="margin:25px; width:100px; height:40px; font-size:15px;">
                    <img src="{{asset('image/store/check-box.png')}}" style="width:18px;"> filter</i>
                </button>
            </form>

            @if(Auth::check())
            @if(Auth::user()['roles']==2)
            <div class="favourite-area">
                <a href="{{ url('/') }}"><img src="{{ asset('image/store/edit.png') }}" style="width:100px;"
                        alt="" /></a>
            </div>
            <div class="favourite-area">
                <a href="#"><img src="{{ asset('image/store/heart.svg') }}" style="width:60px; height:60px;"
                        alt="" /></a>
            </div>
            <div class="cart-area">
                <a href="#" id="essenceCartBtn">
                    <img src="{{ asset('image/store/bag.svg') }}" alt="" />
                    {{-- <span>{{$cartNum->incart}}</span> --}}
                </a>
            </div>
            <!-- ##### Right Side Cart Area ##### -->
            <div class="cart-bg-overlay"></div>

            <div class="right-side-cart-area">
                <!-- 장바구니 -->
                <div class="cart-button">
                    <a href="#" id="rightSideCart"><img src="{{ asset('image/store/bag.svg') }}" alt="" />
                        {{-- <span>{{$cartNum->incart}}</span> --}}
                    </a>
                </div>
                <!-- 장바구니 슬라이드-->
                <div class="cart-bg-overlay"></div>

                <div class="right-side-cart-area">
                    <div class="cart-button">
                        <a href="#" id="rightSideCart"><img src="{{ asset('image/store/bag.svg') }}" alt="" />
                            {{-- <span>{{$cartNum->incart}}</span> --}}
                        </a>
                    </div>

                    <div class="cart-content d-flex">
                        <!-- 장바구니 리스트 -->
                        <div class="cart-list">
                            @foreach($cartProducts as $product)

                            <!-- Single Cart Item -->
                            <div class="single-cart-item">
                                <a href="{{ url('/view') }}/{{$product->num}}" class="product-image">
                                    <img src="{{$product->url_of_illustration}}" class="cart-thumb" alt="" />
                                    <!-- Cart Item Desc -->
                                    <div class="cart-item-desc">
                                        <span class="product-remove"><i class="fa fa-close"
                                                aria-hidden="true"></i></span>
                                        <!-- <span class="badge">{{$product->nickname}}</span> -->
                                        <h6>
                                            {{$product->illustration_title}}
                                        </h6>
                                        <p class="price">
                                            {{$product->price_of_illustration}}
                                            ₩
                                        </p>

                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>

                        <!-- Cart Summary -->
                        <div class="cart-amount-summary">
                            <h2>Summary</h2>
                            <ul class="summary-table">
                                <li>
                                    <span>subtotal:</span>
                                </li>
                                <li>
                                    <span>delivery:</span> <span>Free</span>
                                </li>
                                <li>
                                    <span>discount:</span> <span>0</span>
                                </li>
                                <li>
                                    {{-- <span>total:</span> <span>{{$cartNum->sumprice}} ₩</span> --}}
                                </li>
                            </ul>
                            <div class="checkout-btn mt-100">
                                <a href="{{url('/buyIllustInCart')}}" class="btn essence-btn">check
                                    out</a>
                            </div>
                        </div>
                    </div>
                    <!-- ##### Right Side Cart End ##### -->

                    <div class="user-login-info">
                        <a href="{{ url('/myPage') }}"><img src="{{ asset('image/store/user.svg') }}" alt="" />
                        </a>
                    </div>

                    <div class="user-login-info">
                        <form method="post" action="{{ route('logout') }}" id="frm">
                            @csrf
                            <a href="#" onclick="document.getElementById('frm').submit();"><img
                                    src="{{ asset('image/store/logout.png') }}" style="width:80px;" /></a>
                        </form>
                    </div>
                </div>

                @elseif(Auth::user()['roles']==3)

                <div class="user-login-info" id="alramimg" style="">
                    <a href="#" style="">
                        <button onclick="document.getElementById('id01').style.display='block'" class="w3-button" style="background-color: transparent !important;
                         outline: none;">
                            <img src="{{asset('image/store/message.png')}}" style="display:inline-block">
                            <span id="messagecount" class="list-group-item-danger"
                                style="margin-top:1%; position:absolute; display:inline-block; z-index:100; background-color:white;"></span>
                        </button>
                    </a>
                </div>

                <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-card-4" style="padding:1%;">
                        <div class='list_title'>
                            <img src='../../../image/logo_book.png' class='logo'>
                            <b class="logo_moji">&nbsp;メッセージ</b>
                            <img src='../svg/closed_icon.svg' class="closed">
                        </div>
                        <hr class="holine">
                        <div>
                            <input type='text' placeholder='メッセージを検索' class='form-control' />
                            <img class='search' src='../../../image/search.png'>
                        </div>
                        <div class="message_head">
                            <span class="message_head_li">ニックネーム</span>
                            <span class="message_head_li">メッセージ</span>
                            <span class="message_head_li" style="margin-right: 0;margin-left: -3%;">DATE</span>
                        </div>
                        <div class="message_box">
                            @foreach ($invite_messages as $invite)
                            <div class="message_box_ul">
                                <div style="font-size:20px"><b>-</b></div>
                                <span class="message_box_li" style="width:100px;">{{$invite->from_id}}</span>
                                <!-- num으로 받던걸 message_num으로 받음, 245 고친부분. --># 
                                <span class="message_box_li" style="width:430px;text-align:center;margin-left:1%;margin-right:4%;">
                                    <a id="viewMessage" class="{{$invite->message_num}}" href="{{url("/viewMessage/$invite->num")}}">{{$invite->message_title}}</a></span>

                                <span class="message_box_li">{{$invite->created_ata}}</span>
                                <span class="message_box_li_delete"><img src="/image/tool_icon/edit_delete.png" alt=""></span>
                            </div>
                            @endforeach
                        </div>
                        <hr class="holine">
                    </div>
                </div>
                @endif
                @endif
                <div class="user-login-info">
                    <a href="{{ url('/myPage') }}"><img src="{{ asset('image/store/user.svg') }}" alt="" />
                    </a>
                </div>
                <div class="user-login-info">
                    <form method="post" action="{{ route('logout') }}" id="frm">
                        @csrf
                        <a href="#" onclick="document.getElementById('frm').submit();"><img src="{{ asset('image/store/logout.png') }}" style="width:80px;" /></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
