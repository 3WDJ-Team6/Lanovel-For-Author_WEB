    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <nav class="classy-navbar" id="essenceNav">
                <a class="nav-brand" href="{{asset('/store')}}"><img src="{{asset('image/store/illustore.png')}}" alt=""
                        style="width:200px;"></a>
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <div class="classy-menu">
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <div class="classynav">
                        <ul>
                            <li><a href="{{url('menu/1')}}">배경</a></li>
                            <li><a href="{{url('menu/2')}}">캐릭터</a></li>
                            <li><a href="{{url('menu/3')}}">소품</a></li>
                            <li><a href="{{url('/illustCreate')}}">등록</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="header-meta d-flex clearfix justify-content-end">

                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>

                <form action="{{url('store/find/search')}}" method="post">

                    <button type="submit" style="margin:30px;"><i class="fa fa-search">세부검색</i></button>
                </form>
                @if(Auth::check())
                <div class="favourite-area">
                    <a href="#"><img src="{{asset('image/store/heart.svg')}}" alt=""></a>
                </div>
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn">
                        <img src="{{asset('image/store/bag.svg')}}" alt="">
                        <span>3</span></a>
                </div>
                <!-- ##### Right Side Cart Area ##### -->
                <div class="cart-bg-overlay"></div>

                <div class="right-side-cart-area">

                    <!-- Cart Button -->
                    <div class="cart-button">
                        <a href="#" id="rightSideCart"><img src="{{asset('image/store/bag.svg')}}" alt="">
                            <span>3</span></a>
                    </div>

                    <div class="cart-content d-flex">

                        <!-- Cart List Area -->
                        <div class="cart-list">
                            <!-- Single Cart Item -->
                            <div class="single-cart-item">
                                <a href="#" class="product-image">
                                    <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                                    <!-- Cart Item Desc -->
                                    <div class="cart-item-desc">
                                        <span class="product-remove"><i class="fa fa-close"
                                                aria-hidden="true"></i></span>
                                        <span class="badge">Mango</span>
                                        <h6>Button Through Strap Mini Dress</h6>
                                        <p class="size">Size: S</p>
                                        <p class="color">Color: Red</p>
                                        <p class="price">$45.00</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Single Cart Item -->
                            <div class="single-cart-item">
                                <a href="#" class="product-image">
                                    <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                                    <!-- Cart Item Desc -->
                                    <div class="cart-item-desc">
                                        <span class="product-remove"><i class="fa fa-close"
                                                aria-hidden="true"></i></span>
                                        <span class="badge">Mango</span>
                                        <h6>Button Through Strap Mini Dress</h6>
                                        <p class="size">Size: S</p>
                                        <p class="color">Color: Red</p>
                                        <p class="price">$45.00</p>
                                    </div>
                                </a>
                            </div>

                            <!-- Single Cart Item -->
                            <div class="single-cart-item">
                                <a href="#" class="product-image">
                                    <img src="{{asset('image/store/product-1.png')}}" class="cart-thumb" alt="">
                                    <!-- Cart Item Desc -->
                                    <div class="cart-item-desc">
                                        <span class="product-remove"><i class="fa fa-close"
                                                aria-hidden="true"></i></span>
                                        <span class="badge">Mango</span>
                                        <h6>Button Through Strap Mini Dress</h6>
                                        <p class="size">Size: S</p>
                                        <p class="color">Color: Red</p>
                                        <p class="price">$45.00</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Cart Summary -->
                        <div class="cart-amount-summary">

                            <h2>Summary</h2>
                            <ul class="summary-table">
                                <li><span>subtotal:</span> <span>$274.00</span></li>
                                <li><span>delivery:</span> <span>Free</span></li>
                                <li><span>discount:</span> <span>-15%</span></li>
                                <li><span>total:</span> <span>$232.00</span></li>
                            </ul>
                            <div class="checkout-btn mt-100">
                                <a href="checkout.html" class="btn essence-btn">check out</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ##### Right Side Cart End ##### -->

                <div class="user-login-info">
                    <a href="{{url('/myPage')}}"><img src="{{asset('image/store/user.svg')}}" alt=""></a>

                </div>
                <div class="user-login-info">
                    <form method="post" action="{{route('logout')}}" id="frm">
                        @csrf
                        <a href="#" onclick="document.getElementById('frm').submit();"><img
                                src="{{asset('image/store/logout.png')}}" style="width:80px;"></a>
                    </form>
                </div>

                @else
                <div class="user-login-info">
                    <a href="{{route('login')}}"><img src="{{asset('image/store/login.png')}}" alt=""></a>
                </div>
                @endif

            </div>

        </div>
    </header>
