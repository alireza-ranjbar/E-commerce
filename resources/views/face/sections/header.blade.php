<header class="header-area sticky-bar">
    <div class="main-header-wrap">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 col-lg-2">
                    <div class="logo pt-40">
                        <a href="{{route('index')}}">
                            <h3 class="font-weight-bold">Zoola</h3>
                        </a>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7">
                    <div class="main-menu text-center">
                        <nav>
                            <ul>
                                @if(!empty(session()->get('compareProducts')))
                                <li class="angle-shape">
                                    <a class="text-primary" href="{{route('compare.show')}}"> مقایسه محصولات: <strong>{{count(session()->get('compareProducts'))}}</strong> </a>
                                </li>
                                @endif

                                <li class="angle-shape">
                                    <a href="{{route('aboutUs')}}"> درباره ما </a>
                                </li>

                                <li><a href="{{route('contactUs')}}"> تماس با ما </a></li>

                                <li class="angle-shape">
                                    <a href="shop.html"> فروشگاه </a>

                                    <ul class="mega-menu">
                                        @php
                                            $firstThreeCategories = App\Models\Category::where('parent_id',0)->get()->take(3);
                                        @endphp

                                        @foreach ($firstThreeCategories as $category)
                                        <li>
                                            <a class="menu-title" href="#">{{$category->name}}</a>
                                            <ul>
                                                @foreach ($category->children as $childCategroy)
                                                    <li>
                                                        <a href="{{ route('face.categories.show', ['category' => $childCategroy]) }}">{{$childCategroy->name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="angle-shape">
                                    <a href="{{ route('index') }}"> صفحه اصلی </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">
                    <div class="header-right-wrap pt-40">
                        <div class="header-search">
                            <a class="search-active" href="#"><i class="sli sli-magnifier"></i></a>
                        </div>
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    @if(\Cart::getContent()->count() > 0)
                                    <span class="count-style">{{\Cart::getContent()->count()}}</span>
                                    @endif
                                </span>
                                @if(\Cart::getContent()->count() > 0)
                                <span class="cart-price">{{number_format(\Cart::getTotal())}}</span>
                                <span>تومان</span>
                                @endif
                            </button>
                            <div class="shopping-cart-content">
                                <div class="shopping-cart-top">
                                    <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                    <h4>سبد خرید</h4>
                                </div>
                                @if(\Cart::getContent()->count() == 0)
                                    <p class="text-center">سبد خرید شما خالی است</p>
                                @else
                                    <ul>
                                        @foreach (\Cart::getContent() as $item)
                                        <li class="single-shopping-cart">
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{route('face.product.show',['product' => $item->associatedModel->slug])}}">{{$item->name}}</a></h4>
                                                <span>{{$item->quantity}} x {{number_format($item->price)}}</span>
                                                <div dir="rtl">
                                                    <p class="mb-0">{{\App\Models\Attribute::find($item->attributes->attribute_id)->name}}: {{$item->attributes->value}}</p>
                                                    @if($item->attributes->sale_check)
                                                    <p style="color: red">{{$item->attributes->discount_percent}}% تخفیف</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="shopping-cart-img">
                                                <a href="{{route('face.product.show',['product' => $item->associatedModel->slug])}}"><img alt="" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$item->associatedModel->primary_image)}}" /></a>
                                                <div class="item-close">
                                                    <a href="#"><i class="sli sli-close"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                                <hr>
                                <div class="mt-3">
                                    <div class="shopping-cart-total d-flex justify-content-between align-items-center" style="direction: rtl;">
                                        <h5>
                                            جمع کل :
                                        </h5>
                                        <span class="shop-total">
                                            {{number_format(\Cart::getTotal())}} تومان
                                        </span>
                                    </div>
                                    <div class="shopping-cart-btn btn-hover text-center">
                                        <a class="default-btn" href="{{route('cart.checkout')}}">
                                            ثبت سفارش
                                        </a>
                                        <a class="default-btn" href="{{route('cart.show')}}">
                                            سبد خرید
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="setting-wrap">
                            <button class="setting-active">
                                <i class="sli sli-settings"></i>
                            </button>
                            <div class="setting-content">
                                <ul class="text-right">
                                    @auth
                                        <li><a href="{{route('profile.user-account.index')}}">پروفایل</a></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" style="font-size: 1rem;">خروج</button>
                                            </form>
                                        </li>
                                    @else
                                        <li><a href="{{route('login')}}">ورود</a></li>
                                        <li><a href="{{ route('register') }}">ایجاد حساب</a></li>
                                    @endauth


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-search start -->
        <div class="main-search-active">
            <div class="sidebar-search-icon">
                <button class="search-close">
                    <span class="sli sli-close"></span>
                </button>
            </div>
            <div class="sidebar-search-input">
                <form>
                    <div class="form-search">
                        <input id="search" class="input-text" value="" placeholder=" ...جستجو " type="search" />
                        <button>
                            <i class="sli sli-magnifier"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="header-small-mobile">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a href="index.html">
                            <h4 class="font-weight-bold">WebProg.ir</h4>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <div class="cart-wrap">
                            <button class="icon-cart-active">
                                <span class="icon-cart">
                                    <i class="sli sli-bag"></i>
                                    <span class="count-style">02</span>
                                </span>

                                <span class="cart-price">
                                    500,000
                                </span>
                                <span>تومان</span>
                            </button>
                            <div class="shopping-cart-content">
                                <div class="shopping-cart-top">
                                    <a class="cart-close" href="#"><i class="sli sli-close"></i></a>
                                    <h4>سبد خرید</h4>
                                </div>
                                <ul style="height: 400px;">
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-title">
                                            <h4><a href="#"> لورم ایپسوم </a></h4>
                                            <span>1 x 90.00</span>
                                        </div>

                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-1.svg" /></a>
                                            <div class="item-close">
                                                <a href="#"><i class="sli sli-close"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="single-shopping-cart">
                                        <div class="shopping-cart-title">
                                            <h4><a href="#"> لورم ایپسوم </a></h4>
                                            <span>1 x 9,000</span>
                                        </div>
                                        <div class="shopping-cart-img">
                                            <a href="#"><img alt="" src="assets/img/cart/cart-2.svg" /></a>
                                            <div class="item-close">
                                                <a href="#"><i class="sli sli-close"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="shopping-cart-bottom">
                                    <div class="shopping-cart-total d-flex justify-content-between align-items-center"
                                        style="direction: rtl;">
                                        <h4>
                                            جمع کل :
                                        </h4>
                                        <span class="shop-total">
                                            25,000 تومان
                                        </span>
                                    </div>
                                    <div class="shopping-cart-btn btn-hover text-center">
                                        <a class="default-btn" href="checkout.html">
                                            ثبت سفارش
                                        </a>
                                        <a class="default-btn" href="cart-page.html">
                                            سبد خرید
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="sli sli-menu"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
