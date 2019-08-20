<header class="header_area">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="{{ asset('js/jquery/jquery.modal.min.1.js') }}" defer></script>
    <script src="{{ asset('js/invite_user.js') }}" defer></script>
    <link href="{{ asset('css/jquery.modal.min.1.css') }}" rel="stylesheet">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <nav class="classy-navbar" id="essenceNav">
            <a class="nav-brand" href="{{ asset('/store') }}"><img src="{{ asset('image/store/illustore.png') }}" alt="" style="width:200px;" /></a>

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
                        <li><a href="{{ url('menu/1') }}">배경</a></li>
                        <li><a href="{{ url('menu/2') }}">캐릭터</a></li>
                        <li><a href="{{ url('menu/3') }}">소품</a></li>
                        <li><a href="{{ url('/illustCreate') }}">등록</a></li>
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
                <button type="button submit" class="btn btn-light" style="margin:25px; width:100px; height:40px; font-size:15px;">
                    <img src="{{asset('image/store/check-box.png')}}" style="width:18px;"> 필터링</i>
                </button>
            </form>

            @if(Auth::check())
            @if(Auth::user()['roles']==2)
            <div class="favourite-area">
                <a href="{{ url('/') }}"><img src="{{ asset('image/store/edit.png') }}" style="width:100px;" alt="" /></a>
            </div>
            <div class="favourite-area">
                <a href="#"><img src="{{ asset('image/store/heart.svg') }}" style="width:60px; height:60px;" alt="" /></a>
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
                                        <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
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
                                    {{-- <span>{{$cartNum->sumprice}} ₩</span> --}}
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
                            <a href="#" onclick="document.getElementById('frm').submit();"><img src="{{ asset('image/store/logout.png') }}" style="width:80px;" /></a>
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
                <!-- 메시지 모달창 -->
                <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-card-4">
                        <header class="w3-container" style="background-color:#FAEBFF;">
                            <span onclick="document.getElementById('id01').style.display='none'"
                                class="s w3-display-topright" style="cursor:pointer">&times;</span>
                            <h2>New message</h2>
                        </header>
                        <div class="w3-container"  id="w3-modal-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">TITLE</th>
                                        <th scope="col">DATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invite_messages as $invite)
                                    <tr>
                                        <td>{{$invite->from_id}}</td>
                                        <td><a id="viewMessage" class="{{$invite->message_num}}" href="#">{{$invite->message_title}}</a>
                                        </td>
                                        <td>{{$invite->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <footer class="w3-container" style="background-color:#FAEBFF; height:40px;">

                        </footer>
                    </div>
                </div>
                @endif
                @endif
                <!-- ##### Right Side Cart End ##### -->

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
