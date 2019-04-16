    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="{{asset('/store')}}"><img src="{{asset('image/store/illustore.png')}}" alt=""
                        style="width:200px;"></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="{{url('menu/background')}}">배경</a>
                                <ul class="dropdown">
                                    <li><a href="{{url('menu/background')}}">던전</a></li>
                                    <li><a href="{{url('menu/background')}}">판타지</a></li>
                                    <li><a href="{{url('menu/background')}}">역사적 건조물</a></li>
                                    <li><a href="{{url('menu/background')}}">공장</a></li>
                                    <li><a href="{{url('menu/background')}}">풍경</a></li>
                                    <li><a href="{{url('menu/background')}}">도로</a></li>
                                    <li><a href="{{url('menu/background')}}">우주</a></li>
                                    <li><a href="{{url('menu/background')}}">도시</a></li>
                                </ul>
                            </li>
                            <li><a href="{{url('menu/character')}}">캐릭터</a>
                                <ul class="dropdown">
                                    <li><a href="{{url('menu/character')}}">동물</a></li>
                                    <li><a href="{{url('menu/character')}}">생물</a></li>
                                    <li><a href="{{url('menu/character')}}">휴머노이드</a></li>
                                    <li><a href="{{url('menu/character')}}">로봇</a></li>
                                </ul>
                            </li>
                            <li><a href="{{url('menu/object')}}">소품</a>
                                <ul class="dropdown">
                                    <li><a href="{{url('menu/object')}}">의류</a></li>
                                    <li><a href="{{url('menu/object')}}">음식</a></li>
                                    <li><a href="{{url('menu/object')}}">가구</a></li>
                                    <li><a href="{{url('menu/object')}}">무기</a></li>
                                    <li><a href="{{url('menu/object')}}">전자제품</a></li>
                                    <li><a href="{{url('menu/object')}}">인테리어</a></li>
                                    <li><a href="{{url('menu/object')}}">산업도구</a></li>
                                    <li><a href="{{url('menu/object')}}">기타도구</a></li>
                                </ul>
                            </li>
                            <li><a href="{{url('store/menu/upload')}}">등록</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">

                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>

                <!-- Search Area 2 -->
                <!-- <div class="search-area"> -->
                <form action="{{url('store/find/detail')}}" method="post">
                    <button type="submit" style="margin:30px;"><i class="fa fa-search">세부검색</i></button>
                </form>
                <!-- </div> -->

                <!-- User Login Info -->
                <div class="user-login-info">
                    <a href="{{route('login')}}"><img src="{{asset('image/store/user.svg')}}" alt=""></a>
                </div>

            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->
