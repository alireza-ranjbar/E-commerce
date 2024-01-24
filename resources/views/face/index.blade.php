@extends('face.layouts.face')
@section('title','index')

@section('script')
<script>
    $('.product-tab-list a').click(function(){
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            let selectedItem =  $(this).attr('href');

            $(selectedItem).addClass('active');
            $(selectedItem).siblings().removeClass('active');
    });

    //send data from variation select box to variation price section & variation quantity section
    $('.select-variation').on('change',function(){
        $(this).parents('.modal-body').find('.new.sale').empty()
        $(this).parents('.modal-body').find('.old.sale').empty()
        $(this).parents('.modal-body').find('.new.nonsale').empty()

        let selectedVariation = JSON.parse(this.value);

        if(selectedVariation.sale_check){
            $(this).parents('.modal-body').find('.new.sale').text(toPersianNum(number_format(selectedVariation.sale_price)) + ' تومان');
            $(this).parents('.modal-body').find('.old.sale').text(toPersianNum(number_format(selectedVariation.price)));
        }else{
            $(this).parents('.modal-body').find('.new.nonsale').text(toPersianNum(number_format(selectedVariation.price)) + ' تومان');
        }

        $(this).parents('.modal-body').find('.quantity-input').attr('data-max',selectedVariation.quantity);
        $(this).parents('.modal-body').find('.quantity-input').val(1);

    });

    //send data from variation select box to add-to-cart form in hidden form
    $('.select-variation').on('change',function(){
        let selectedVariation = JSON.parse(this.value);
        $(this).parents('.modal-body').find('#selectedVariation').val(selectedVariation.id);
    });


</script>
@endsection

@section('content')

{{-- slider --}}
<div class="slider-area section-padding-1">
    <div class="slider-active owl-carousel nav-style-1">
        @foreach ($sliders as $slider)
        <div class="single-slider slider-height-1 bg-paleturquoise">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6 text-right">
                        <div class="slider-content slider-animated-1">
                            <h1 class="animated">{{$slider->title}}</h1>
                            <p class="animated">
                                {{$slider->text}}
                            </p>
                            <div class="slider-btn btn-hover">
                                <a class="animated" href="{{$slider->button_link}}">
                                    <i class="{{$slider->button_icon}}"></i>
                                    {{$slider->button_text}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 col-sm-6">
                        <div class="slider-single-img slider-animated-1">

                            <img class="animated" src="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$slider->image)}}"
                                alt="{{$slider->image}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- top banners --}}
<div class="banner-area pt-100 pb-65">
    <div class="container">
        <div class="row">

            @foreach ($topBanners->chunk(3)->first() as $topBanner)
            <div class="col-lg-4 col-md-4">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="{{$topBanner->button_link}}"><img class="animated"
                            src="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$topBanner->image)}}"
                            alt="{{$topBanner->image}}" />{{$topBanner->button_text}}</a>
                    <div class="banner-content-2 banner-position-5">
                        <h4>{{$topBanner->title}}</h4>
                    </div>
                </div>
            </div>
            @endforeach

            @foreach ($topBanners->chunk(3)->last() as $topBanner)
            <div class="col-lg-6 col-md-6">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="product-details.html"><img class="animated"
                            src="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$topBanner->image)}}"
                            alt="{{$topBanner->image}}" /></a>
                    <div
                        class="{{ $loop->last ? 'banner-content-3 banner-position-7' : 'banner-content banner-position-6 text-right' }}">
                        <h3>{{$topBanner->title}}</h3>
                        <h2>{{$topBanner->text}}</h2>
                        <a href="{{$topBanner->button_link}}">{{$topBanner->button_text}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- first product area --}}
<div class="product-area pb-70">
    <div class="container">
        <div class="section-title text-center pb-40">
            <h2> لورم ایپسوم </h2>
            <p>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و
                متون
                بلکه روزنامه و مجله
            </p>
        </div>
        <div class="product-tab-list nav pb-60 text-center flex-row-reverse">
            @foreach ($firstThreeparentCategories as $parentCategory)
            <a class="{{$loop->first ? 'active' : ''}}" href="#product-{{$parentCategory->id}}" data-toggle="tab">
                <h4>{{$parentCategory->name}}</h4>
            </a>
            @endforeach
        </div>
        <div class="tab-content jump-2">
            @foreach ($firstThreeparentCategories as $parentCategory)
            <div id="product-{{$parentCategory->id}}" class="tab-pane {{$loop->first ? 'active' : ''}}">
                <div class="ht-products product-slider-active owl-carousel">
                    <!--Product Start-->
                    @foreach ($parentCategory->children as $childCategory)
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="{{ route('face.product.show' , ['product' => $childCategory->products->first()->slug]) }}" class="ht-product-image">
                                    <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$childCategory->products->first()->primary_image)}}"
                                        alt="Universal Product Style" />
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" class="quick-view" data-toggle="modal"
                                                data-target="#p{{$childCategory->products->first()->id}}"><i
                                                    class="sli sli-magnifier">
                                                    </i><span
                                                    class="ht-product-action-tooltip"> مشاهده سریع
                                                </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-heart"></i><span
                                                    class="ht-product-action-tooltip"> افزودن به
                                                    علاقه مندی ها </span></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('compare.add', ['product' => $childCategory->products->first()->id]) }}"><i class="sli sli-refresh"></i><span
                                                    class="ht-product-action-tooltip"> مقایسه
                                                </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">{{$parentCategory->name}}</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="{{ route('face.product.show' , ['product' => $childCategory->products->first()->slug]) }}">{{$childCategory->products->first()->name}}</a>
                                    </h4>
                                    <div class="ht-product-price">
                                        @if ($childCategory->products->first()->sale_check)
                                        <span class="new">
                                            {{number_format($childCategory->products->first()->sale_check->sale_price)}}
                                            تومان
                                        </span>
                                        <span class="old">
                                            {{number_format($childCategory->products->first()->sale_check->price)}}
                                            تومان
                                        </span>
                                        @else
                                        <span class="new">
                                            {{number_format($childCategory->products->first()->price_check->price)}}
                                            تومان
                                        </span>
                                        @endif
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                                        <div data-rating-stars="5"
                                            data-rating-readonly="true"
                                            data-rating-value="{{ ceil($childCategory->products->first()->productRates->avg('rate')) }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!--Product End-->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- featured comments --}}
<div class="testimonial-area pt-80 pb-95 section-margin-1" style="background-image: url({{ asset('images/face/bg-1.jpg') }})">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 ml-auto mr-auto">
                <div class="testimonial-active owl-carousel nav-style-1">
                    <div class="single-testimonial text-center">
                        <img src="{{ asset('images/face/testi-1.png') }}" alt="" />
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                            چاپگرها و
                            متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد
                            نیاز و
                            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته،
                            حال و
                            آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                        </p>
                        <div class="client-info">
                            <img src="{{ asset('images/face/icons/testi.png') }}" alt="" />
                            <h5>لورم ایپسوم</h5>
                        </div>
                    </div>
                    <div class="single-testimonial text-center">
                        <img src="{{ asset('images/face/testi-2.png') }}" alt="" />
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                            چاپگرها و
                            متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد
                            نیاز و
                            کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته،
                            حال و
                            آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت
                        </p>
                        <div class="client-info">
                            <img src="{{ asset('images/face/icons/testi.png') }}" alt="" />
                            <h5>لورم ایپسوم</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- bottom banners --}}
<div class="banner-area pb-120">
    <div class="container">
        <div class="row">

            @foreach ($bottomBanners as $bottomBanner)
            <div class="col-lg-6 col-md-6 text-right">
                <div class="single-banner mb-30 scroll-zoom">
                    <a href="{{$bottomBanner->button_link}}"><img
                            src="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$bottomBanner->image)}}"
                            alt="{{$bottomBanner->image}}" /></a>
                    <div class="banner-content banner-position-3">
                        <h3>{{$bottomBanner->title}}</h3>
                        <h2>{{$bottomBanner->text}}</h2>
                        <a href="{{$bottomBanner->button_link}}">{{$bottomBanner->button_text}}</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
{{-- three features in bottom --}}
<div class="feature-area" style="direction: rtl;">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40">
                    <div class="feature-icon">
                        <img src="{{ asset('images/face/icons/free-shipping.png') }}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>لورم ایپسوم</h4>
                        <p>لورم ایپسوم متن ساختگی</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40 pl-50">
                    <div class="feature-icon">
                        <img src="{{ asset('images/face/icons/security.png') }}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>لورم ایپسوم</h4>
                        <p>24x7 لورم ایپسوم</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4">
                <div class="single-feature text-right mb-40">
                    <div class="feature-icon">
                        <img src="{{ asset('images/face/icons/support.png') }}" alt="" />
                    </div>
                    <div class="feature-content">
                        <h4>لورم ایپسوم</h4>
                        <p>لورم ایپسوم متن ساختگی</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@foreach ($categories as $category)
<div class="modal fade" id="p{{$category->products->first()->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                        <div class="product-details-content quickview-content">
                            <h2 class="text-right mb-4">{{$category->products->first()->name}}</h2>
                            <div class="product-details-price">
                                <span class="new sale">@if($category->products->first()->sale_check) {{number_format($category->products->first()->sale_check->sale_price)}} تومان@endif</span>
                                <span class="old sale">@if($category->products->first()->sale_check) {{number_format($category->products->first()->sale_check->price)}} تومان@endif</span>
                                <span class="new nonsale">@if(!$category->products->first()->sale_check) {{number_format($category->products->first()->price_check->price)}} تومان@endif</span>
                            </div>
                            <div class="pro-details-rating-wrap">
                                <div class="pro-details-rating">
                                    <div data-rating-stars="5"
                                        data-rating-readonly="true"
                                        data-rating-value="{{ ceil($category->products->first()->productRates->avg('rate')) }}">
                                    </div>
                                </div>
                                <span>3 دیدگاه</span>
                            </div>
                            <p class="text-right">
                                {{$category->products->first()->description}}
                            </p>
                            <div class="pro-details-list text-right">
                                <ul class="text-right">
                                    @foreach ($category->products->first()->productAttributes()->with('attribute')->get() as $productAttribute)
                                    <li>- {{ $productAttribute->attribute->name }} : {{ $productAttribute->value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="pro-details-size-color text-right">
                                <div class="pro-details-size w-50">
                                    <span>{{ $category->attributes()->wherePivot('is_variation', 1)->first()->name }}</span>
                                    <select class="form-control select-variation">
                                        @foreach ($category->products->first()->productVariations()->where('quantity', '>' , 0)->get() as $productVariation)
                                        <option
                                        @if($category->products->first()->sale_check)
                                            {{$category->products->first()->sale_check->id == $productVariation->id ? 'selected' : '' ;}}
                                        @else
                                            {{$category->products->first()->price_check->id == $productVariation->id ? 'selected' : '' ;}}
                                        @endif
                                        value="{{ json_encode($productVariation->only(['id','value','price','sale_price','sale_check','quantity'])) }}">{{$productVariation->value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="pro-details-quality">
                                <div class="container">
                                    <form class="row" action="{{route('cart.add',['product' => $category->products->first()])}}" method="POST">
                                        @csrf
                                        @if($category->products->first()->sale_check)
                                        <input id="selectedVariation" type="hidden" name="variationId" value="{{$category->products->first()->sale_check->id}}">
                                        @else
                                        <input id="selectedVariation" type="hidden" name="variationId" value="{{$category->products->first()->price_check->id}}">
                                        @endif
                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton" value="1" data-max="5"/>
                                        </div>
                                        <div class="pro-details-cart">
                                            <button type="submit">افزودن به سبد خرید</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="pro-details-wishlist">
                                    @auth
                                    @if(auth()->user()->wishlist()->where('product_id',$category->products->first()->id)->exists())
                                    <form action="{{route('wishlist.remove',['product' => $category->products->first()->id])}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="p-0 m-0 btn">
                                            <a><i class="fas fa-heart" style="color:red"></i><span
                                                class="ht-product-action-tooltip"></span></a>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{route('wishlist.add',['product' => $category->products->first()->id])}}" method="POST">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="m-0 p-0 btn">
                                            <a><i class="sli sli-heart"></i><span
                                                class="ht-product-action-tooltip"></span>
                                            </a>
                                        </button>
                                    </form>
                                    @endif
                                    @else
                                    <form action="{{route('wishlist.add',['product' => $category->products->first()->id])}}" method="POST">
                                        @csrf
                                        @method('post')
                                        <button type="submit" class="m-0 p-0 btn">
                                        <a><i class="sli sli-heart"></i><span
                                        class="ht-product-action-tooltip"></span></a>
                                    @endauth
                                </div>
                                <div class="pro-details-compare">
                                    <a title="Add To Compare" href="{{route('compare.add', ['product' => $category->products->first()->id])}}"><i class="sli sli-refresh"></i></a>
                                </div>
                            </div>
                            <div class="pro-details-meta">
                                <span>دسته بندی :</span>
                                <ul>
                                    <li><a href="#">{{$category->parent->name}}</a></li>
                                    <li><a href="#">{{$category->name}}</a></li>
                                </ul>
                            </div>
                            <div class="pro-details-meta">
                                <span>تگ ها :</span>
                                <ul>
                                    @foreach ($category->products->first()->tags as $tag)
                                        <li><a href="#">{{ $tag->name }}</a>{{$loop->last ? '' : '،' ;}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="tab-content quickview-big-img">
                            <div id="primary-{{$category->products->first()->id}}" class="tab-pane fade show active">
                                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$category->products->first()->primary_image)}}" alt="" />
                            </div>
                            @foreach ($category->products->first()->productImages as $productImage)
                            <div id="other-{{$productImage->id}}" class="tab-pane fade">
                                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$productImage->image)}}" alt="" />
                            </div>
                            @endforeach

                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="quickview-wrap mt-15">
                            <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                <a class="active" data-toggle="tab" href="#primary-{{$category->products->first()->id}}">
                                    <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$category->products->first()->primary_image)}}" alt="" />
                                </a>
                                @foreach ($category->products->first()->productImages as $productImage)
                                <a data-toggle="tab" href="#other-{{$productImage->id}}">
                                    <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$productImage->image)}}" alt="" />
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endforeach



@endsection

