@extends('face.layouts.face')

@section('title' , 'product-page')
@section('content')

@section('script')
<script>
    //send data from variation select box to variation price section & variation quantity section
    $('.select-variation').on('change',function(){
        $(this).parents('.product-details-area').find('.new.sale').empty()
        $(this).parents('.product-details-area').find('.old.sale').empty()
        $(this).parents('.product-details-area').find('.new.nonsale').empty()

        let selectedVariation = JSON.parse(this.value);

        if(selectedVariation.sale_check){
            $(this).parents('.product-details-area').find('.new.sale').text(toPersianNum(number_format(selectedVariation.sale_price)) + ' تومان');
            $(this).parents('.product-details-area').find('.old.sale').text(toPersianNum(number_format(selectedVariation.price)));
        }else{
            $(this).parents('.product-details-area').find('.new.nonsale').text(toPersianNum(number_format(selectedVariation.price)) + ' تومان');
        }

        $(this).parents('.product-details-area').find('.quantity-input').attr('data-max',selectedVariation.quantity);
        $(this).parents('.product-details-area').find('.quantity-input').val(1);

    });
</script>
@endsection
<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class="active">صفحه محصول </li>
            </ul>
        </div>
    </div>
</div>

<div class="product-details-area pt-100 pb-95">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 order-2 order-sm-2 order-md-1" style="direction: rtl;">
                <div class="product-details-content ml-30">
                    <h2 class="text-right">{{$product->name}}</h2>
                    <div class="product-details-price">
                        @if($product->sale_check)
                        <span class="new sale">
                            {{number_format($product->sale_check->sale_price)}}
                            تومان
                        </span>
                        <span class="old sale">
                            {{number_format($product->sale_check->price)}}
                            تومان
                        </span>
                        @else
                        <span class="new nonsale">
                            {{number_format($product->price_check->price)}}
                            تومان
                        </span>
                        @endif
                    </div>
                    <div class="pro-details-rating-wrap">
                        <div class="pro-details-rating">
                            <div data-rating-stars="5"
                            data-rating-readonly="true"
                            data-rating-value="{{ ceil($product->productRates->avg('rate')) }}">
                            </div>
                        </div>
                        <span>
                            <a href="#">
                                {{-- TODO: href tag --}}
                                @if($product->comments->where('approved',1)->count() == 0)
                                هیچ دیدگاهی برای این محصول ثبت نشده است
                                @else
                                {{$product->comments->where('approved',1)->count()}}
                                دیدگاه
                                @endif
                            </a>
                        </span>
                    </div>
                    <p class="text-right">{{$product->description}}</p>
                    <div class="pro-details-list text-right">
                        <ul>
                            @foreach ($product->category->attributes()->wherePivot('is_filter',1)->get() as $attribute)
                            <li>{{$attribute->name}}: {{$product->productAttributes()->where('attribute_id',$attribute->id)->first()->value}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="pro-details-size-color">
                        <div class="pro-details-size text-right">
                            <span>{{ $product->category->attributes()->wherePivot('is_variation', 1)->first()->name }}</span>
                            <select class="form-control select-variation">
                                @foreach ($product->productVariations()->where('quantity', '>' , 0)->get() as $productVariation)
                                <option
                                @if($product->sale_check)
                                    {{$product->sale_check->id == $productVariation->id ? 'selected' : '' ;}}
                                @else
                                    {{$product->price_check->id == $productVariation->id ? 'selected' : '' ;}}
                                @endif
                                value="{{ json_encode($productVariation->only(['value','price','sale_price','sale_check','quantity'])) }}">{{$productVariation->value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="pro-details-quality">
                        <div class="cart-plus-minus">
                            <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton" value="1" data-max="5" />
                        </div>
                        <div class="pro-details-cart btn-hover">
                            <a href="#"> افزودن به سبد خرید </a>
                        </div>
                        <div class="pro-details-wishlist">
                            @auth
                                @if(auth()->user()->wishlist()->where('product_id',$product->id)->exists())
                                <form action="{{route('wishlist.remove',['product' => $product->id])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="p-0 m-0 btn">
                                        <a><i class="fas fa-heart" style="color:red"></i><span
                                            class="ht-product-action-tooltip"></span></a>
                                    </button>
                                </form>
                                @else
                                <form action="{{route('wishlist.add',['product' => $product->id])}}" method="POST">
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
                                <form action="{{route('wishlist.add',['product' => $product->id])}}" method="POST">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="m-0 p-0 btn">
                                    <a><i class="sli sli-heart"></i><span
                                    class="ht-product-action-tooltip"></span></a>
                                </form>
                            @endauth
                        </div>
                        <div class="pro-details-compare">
                            <a title="Add To Compare" href="{{route('compare.add', ['product' => $product->id])}}"><i class="sli sli-refresh"></i></a>
                        </div>
                    </div>
                    <div class="pro-details-meta">
                        <span> دسته بندی : </span>
                        <ul>
                            <li><a href="{{route('face.categories.show',['category' => $product->category->slug])}}">{{$product->category->name}}</a></li>
                        </ul>
                    </div>
                    <div class="pro-details-meta">
                        <span> تگ : </span>
                        <ul>
                            @foreach ($product->tags as $tag)
                                <li><a href="#">{{$tag->name}}{{$loop->last ? '' : '،' ;}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 order-1 order-sm-1 order-md-2">
                <div class="product-details-img">
                    <div class="zoompro-border zoompro-span">
                        <img class="zoompro" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}"
                            data-zoom-image="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}" alt="{{$product->name}}" />

                    </div>
                    <div id="gallery" class="mt-20 product-dec-slider">
                        <a data-image="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}"
                            data-zoom-image="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}">
                            <img width="100" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}" alt="">
                        </a>
                        @foreach ($product->productImages as $image)
                        <a data-image="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$image->image)}}"
                            data-zoom-image="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$image->image)}}">
                            <img width="100" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$image->image)}}" alt="">
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="description-review-area pb-95">
    <div class="container">
        <div class="row" style="direction: rtl;">
            <div class="col-lg-8 col-md-8">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <a class="{{ count($errors) > 0 ? '' : 'active' }}" data-toggle="tab" href="#description"> توضیحات </a>
                        <a data-toggle="tab" href="#information"> اطلاعات بیشتر </a>
                        <a class="{{ count($errors) > 0 ? 'active' : '' }}" data-toggle="tab" href="#comments">دیدگاه({{$product->comments->where('approved',1)->count()}})</a>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="description" class="tab-pane {{ count($errors) > 0 ? '' : 'active' }}">
                            <div class="product-description-wrapper">
                                <p class="text-justify">{{$product->description}}</p>
                            </div>
                        </div>
                        <div id="information" class="tab-pane">
                            <div class="product-anotherinfo-wrapper text-right">
                                <ul>
                                    @foreach ($product->category->attributes()->where('is_filter',1)->get() as $attribute)
                                    <li><span> {{$attribute->name}} : </span>{{$product->productAttributes()->where('attribute_id',$attribute->id)->first()->value}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div id="comments" class="tab-pane {{ count($errors) > 0 ? 'active' : '' }}">
                            <div class="review-wrapper">
                                @foreach ($product->comments()->where('approved',1)->get() as $comment)
                                <div class="single-review">
                                    <div class="review-img">
                                        <img src="{{$comment->user->avatar}}" alt="">
                                    </div>
                                    <div class="review-content text-right">
                                        <p class="text-right">{{$comment->text}}</p>
                                        <div class="review-top-wrap">
                                            <div class="review-name">
                                                <h4>{{$comment->user->name}}</h4>
                                            </div>
                                            <div class="review-rating mr-2">
                                                <div data-rating-stars="5"
                                                data-rating-readonly="true"
                                                data-rating-value="{{ $product->productRates()->where('user_id',$comment->user->id)->first()->rate }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <div class="ratting-form-wrapper text-right">
                                <span> نوشتن دیدگاه </span>
                                <div
                                id="rating-stars"
                                data-rating-stars="5"
                                data-rating-value="0"
                                data-rating-input="#rating-input">
                                </div>
                                <div class="star-box-wrap">

                                </div>

                                <div id="form-area" class="ratting-form mb-2">
                                    <form action="{{route('comment.store',['product'=>$product->id])}}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="rating-form-style mb-20">
                                                    <label> متن دیدگاه : </label>
                                                    <textarea name="text"></textarea>
                                                </div>
                                                <input type="hidden" id="rating-input" name="rate" value="0"/>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-submit">
                                                    <input type="submit" value="ارسال">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @include('face.sections.errors')

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="pro-dec-banner">
                    <a href="#"><img src="assets/img/banner/banner-7.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-area pb-70">
    <div class="container">
        <div class="section-title text-center pb-60">
            <h2> محصولات مرتبط </h2>
            <p>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است.
                چاپگرها و متون بلکه روزنامه و مجله
            </p>
        </div>
        <div class="arrivals-wrap scroll-zoom">
            <div class="ht-products product-slider-active owl-carousel">
                <!--Product Start-->
                <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                    <div class="ht-product-inner">
                        <div class="ht-product-image-wrap">
                            <a href="product-details.html" class="ht-product-image">
                                <img src="assets/img/product/product-1.svg" alt="Universal Product Style" />
                            </a>
                            <div class="ht-product-action">
                                <ul>
                                    <li>
                                        <a href="#" data-toggle="modal" data-target="#exampleModal"><i
                                                class="sli sli-magnifier"></i><span
                                                class="ht-product-action-tooltip"> مشاهده سریع
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="sli sli-heart"></i><span
                                                class="ht-product-action-tooltip"> افزودن به
                                                علاقه مندی ها </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="sli sli-refresh"></i><span
                                                class="ht-product-action-tooltip"> مقایسه
                                            </span></a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="sli sli-bag"></i><span
                                                class="ht-product-action-tooltip"> افزودن به سبد
                                                خرید </span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="ht-product-content">
                            <div class="ht-product-content-inner">
                                <div class="ht-product-categories">
                                    <a href="#">لورم</a>
                                </div>
                                <h4 class="ht-product-title text-right">
                                    <a href="product-details.html"> لورم ایپسوم </a>
                                </h4>
                                <div class="ht-product-price">
                                    <span class="new">
                                        55,000
                                        تومان
                                    </span>
                                    <span class="old">
                                        75,000
                                        تومان
                                    </span>
                                </div>
                                <div class="ht-product-ratting-wrap">
                                    <span class="ht-product-ratting">
                                        <span class="ht-product-user-ratting" style="width: 100%;">
                                            <i class="sli sli-star"></i>
                                            <i class="sli sli-star"></i>
                                            <i class="sli sli-star"></i>
                                            <i class="sli sli-star"></i>
                                            <i class="sli sli-star"></i>
                                        </span>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--Product End-->
            </div>
        </div>
    </div>
</div>


@endsection
