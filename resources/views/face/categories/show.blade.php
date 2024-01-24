@extends('face.layouts.face')
@section('title','فروشگاه')

@section('script')
<script>
    function filter(){
        let filterAttributes = @json($filterAttributes);
        filterAttributes.map(filterAttribute =>{
            let filterAttributeVal = $(`.filterAttribute-${filterAttribute.id}:checked`).map(function(){
                return this.value;
            }).get().join('-');

            if(filterAttributeVal == ''){
                $(`#attribute-${filterAttribute.id}`).prop('disabled',true);
            }else{
                $(`#attribute-${filterAttribute.id}`).val(filterAttributeVal);
            }
        });


        let variationAttributeVal = $('.variationAttribute:checked').map(function(){
            return this.value;
        }).get().join('-');

        if(variationAttributeVal == ''){
            $('#variation').prop('disabled',true);
        }else{
            $('#variation').val(variationAttributeVal);
        }


        let searchVal = $('#search-input').val();
        if(searchVal == ""){
            $('#search-value').prop('disabled',true);
        }else{
            $('#search-value').val(searchVal);
        }

        let sortVal = $('#sortby-input').val();
        if(sortVal == ""){
            $('#sort-value').prop('disabled',true)
        }else{
            $('#sort-value').val(sortVal);
        }



        $('#filter-form').submit();

    }

    // decodes url
    $('#filter-form').on('submit', function(event) {
        event.preventDefault();
        let currentUrl = '{{ url()->current() }}';
        let url = currentUrl + '?' + decodeURIComponent($(this).serialize())
        $(location).attr('href', url);
    });
    // decodes url also when pagination is implpemented
    $('#pagination li a').map(function(){
            let decodeUrl = decodeURIComponent($(this).attr('href'));
            if( $(this).attr('href') !== undefined ){
                $(this).attr('href' , decodeUrl);
            }
    });
</script>
@endsection

@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
        <ul>
            <li>
            <a href="{{ route('index') }}">صفحه اصلی</a>
            </li>
            <li class="active">فروشگاه </li>
        </ul>
        </div>
    </div>
</div>


<div class="shop-area pt-95 pb-100">
    <div class="container">
        <div class="row flex-row-reverse text-right">

        <!-- sidebar -->
        <div class="col-lg-3 order-2 order-sm-2 order-md-1">
            <div class="sidebar-style mr-30">

                {{-- search field --}}
                <div class="sidebar-widget">
                    <h4 class="pro-sidebar-title">جستجو </h4>
                    <div class="pro-sidebar-search mb-50 mt-25">
                        <div class="pro-sidebar-search-form">
                            <input id="search-input" type="text" placeholder="... جستجو "
                            value="{{ request()->has('search') ? request()->search : '' }}">
                            <button onclick="filter()">
                                <i class="sli sli-magnifier"></i>
                            </button>
                        </div>
                    </div>
                </div>

            {{-- category --}}
            <div class="sidebar-widget">
                <h4 class="pro-sidebar-title"> دسته بندی </h4>
                <div class="sidebar-widget-list mt-30">
                <ul>
                    {{$category->parent->name}}
                    @foreach ($category->parent->children as $childCategory)
                        <li>
                            <a class="{{ $category->id == $childCategory->id ? 'text-danger' : ''}}"
                            href="{{ route('face.categories.show', ['category' => $childCategory ]) }}">{{ $childCategory->name }}</a>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
            <hr>

            {{-- attribute --}}
            @foreach ($filterAttributes as $filterAttribute)
                <div class="sidebar-widget mt-30">
                    <h4 class="pro-sidebar-title">{{ $filterAttribute->name }}</h4>
                    <div class="sidebar-widget-list mt-20">
                    <ul>
                        @foreach ($filterAttribute->attributesValues as $filterAttributeValue)
                            <li>
                                <div class="sidebar-widget-list-left">
                                    <input type="checkbox" value="{{ $filterAttributeValue->value }}"
                                    onchange="filter()" class="filterAttribute-{{$filterAttribute->id}}"
                                    {{request()->has('attribute.'.$filterAttribute->id) && in_array($filterAttributeValue->value , explode('-',request()->attribute[$filterAttribute->id]))? 'checked' : '' }}> <a href="#">{{ $filterAttributeValue->value }}</a>
                                    <span class="checkmark"></span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    </div>
                </div>
                <hr>
            @endforeach


            {{-- variation --}}
            <div class="sidebar-widget mt-30">
                <h4 class="pro-sidebar-title">{{ $variationAttribute->name }}</h4>
                <div class="sidebar-widget-list mt-20">
                <ul>
                    @foreach ($variationAttribute->variationValues as $variationValue)
                    <li>
                        <div class="sidebar-widget-list-left">
                            <input type="checkbox" value="{{ $variationValue->value }}"
                            class="variationAttribute" onchange="filter()"
                            {{ request()->has('variation') && in_array($variationValue->value, explode('-',request()->variation)) ? 'checked' : '' }}> <a href="#">{{ $variationValue->value }}</a>
                            <span class="checkmark"></span>
                        </div>
                    </li>
                    @endforeach
                </ul>
                </div>
            </div>

            </div>
        </div>

        <!-- content -->
        <div class="col-lg-9 order-1 order-sm-1 order-md-2">
            <!-- shop-top-bar -->
            <div class="shop-top-bar" style="direction: rtl;">

            <div class="select-shoing-wrap">
                <div class="shop-select">
                <select id="sortby-input" onchange="filter()">
                    <option value=""> مرتب سازی </option>
                    <option value="max"
                    {{request()->has('sort') && request()->sort == 'max' ? 'selected' : ''}}> بیشترین قیمت </option>
                    <option value="min"
                    {{request()->has('sort') && request()->sort == 'min' ? 'selected' : ''}}> کم ترین قیمت </option>
                    <option value="latest"
                    {{request()->has('sort') && request()->sort == 'latest' ? 'selected' : ''}}> جدیدترین </option>
                    <option value="oldest"
                    {{request()->has('sort') && request()->sort == 'oldest' ? 'selected' : ''}}> قدیمی ترین </option>
                </select>
                </div>

            </div>

            </div>

            <div class="shop-bottom-area mt-35">
            <div class="tab-content jump">

                <div class="row ht-products" style="direction: rtl;">
                    @foreach ($products as $product)
                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                    <!--Product Start-->
                    <div class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                        <div class="ht-product-inner">
                            <div class="ht-product-image-wrap">
                                <a href="{{route('face.product.show',['product' => $product->slug])}}" class="ht-product-image">
                                    <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}"
                                        alt="Universal Product Style" />
                                </a>
                                <div class="ht-product-action">
                                    <ul>
                                        <li>
                                            <a href="#" class="quick-view" data-toggle="modal"
                                                data-target="#p{{$product->id}}"><i
                                                    class="sli sli-magnifier">
                                                    </i><span
                                                    class="ht-product-action-tooltip"> مشاهده سریع
                                                </span></a>
                                        </li>
                                        <li>
                                            @auth
                                                @if(auth()->user()->wishlist()->where('product_id',$product->id)->exists())
                                                <form action="{{route('wishlist.remove',['product' => $product->id])}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="p-0 m-0 btn">
                                                        <a><i class="fa fa-heart" style="color:red"></i><span
                                                            class="ht-product-action-tooltip">در لیست علاقمندی ها</span></a>
                                                    </button>
                                                </form>
                                                @else
                                                <form action="{{route('wishlist.add',['product' => $product->id])}}" method="POST">
                                                    @csrf
                                                    @method('post')
                                                    <button type="submit" class="m-0 p-0 btn">
                                                        <a><i class="sli sli-heart"></i><span
                                                            class="ht-product-action-tooltip">افزودن به علاقمندی ها</span>
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
                                                class="ht-product-action-tooltip">افزودن به علاقمندی ها</span></a>
                                            @endauth
                                        </li>
                                        <li>
                                            <a href="#"><i class="sli sli-refresh"></i><span
                                                    class="ht-product-action-tooltip"> مقایسه
                                                </span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ht-product-content">
                                <div class="ht-product-content-inner">
                                    <div class="ht-product-categories">
                                        <a href="#">{{$product->category->name}}</a>
                                    </div>
                                    <h4 class="ht-product-title text-right">
                                        <a href="{{route('face.product.show',['product' => $product->slug])}}">{{$product->name}}</a>
                                    </h4>
                                    <div class="ht-product-price">
                                        @if ($product->sale_check)
                                        <span class="new">
                                            {{number_format($product->sale_check->sale_price)}}
                                            تومان
                                        </span>
                                        <span class="old">
                                            {{number_format($product->sale_check->price)}}
                                            تومان
                                        </span>
                                        @else
                                        <span class="new">
                                            {{number_format($product->price_check->price)}}
                                            تومان
                                        </span>
                                        @endif
                                    </div>
                                    <div class="ht-product-ratting-wrap">
                                        <div data-rating-stars="5"
                                            data-rating-readonly="true"
                                            data-rating-value="{{ ceil($product->productRates->avg('rate')) }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Product End-->
                    </div>
                    @endforeach
                </div>

            </div>

            <div id="pagination">
                {{$products->withQueryString()->links('pagination::custom')}}
            </div>

            </div>
        </div>

        </div>
    </div>
</div>


<form id="filter-form">
    @foreach ($filterAttributes as $filterAttribute)
        <input type="hidden" name="attribute[{{$filterAttribute->id}}]" id="attribute-{{$filterAttribute->id}}">
    @endforeach
    <input type="hidden" name="variation" id="variation">
    <input id="search-value" type="hidden" name="search">
    <input id="sort-value" type="hidden" name="sort">
</form>



<!-- Modal -->
@foreach ($products as $product)
<div class="modal fade" id="p{{$product->id}}" tabindex="-1" role="dialog">
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
                            <h2 class="text-right mb-4">{{$product->name}}</h2>
                            <div class="product-details-price">
                                <span class="new sale">@if($product->sale_check) {{number_format($product->sale_check->sale_price)}} تومان@endif</span>
                                <span class="old sale">@if($product->sale_check) {{number_format($product->sale_check->price)}} تومان@endif</span>
                                <span class="new nonsale">@if(!$product->sale_check) {{number_format($product->price_check->price)}} تومان@endif</span>
                            </div>
                            <div class="pro-details-rating-wrap">
                                <div class="pro-details-rating">
                                    <div data-rating-stars="5"
                                        data-rating-readonly="true"
                                        data-rating-value="{{ ceil($product->productRates->avg('rate')) }}">
                                    </div>
                                </div>
                                <span>3 دیدگاه</span>
                            </div>
                            <p class="text-right">
                                {{$product->description}}
                            </p>
                            <div class="pro-details-list text-right">
                                <ul class="text-right">
                                    @foreach ($product->productAttributes()->with('attribute')->get() as $productAttribute)
                                    <li>- {{ $productAttribute->attribute->name }} : {{ $productAttribute->value }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="pro-details-size-color text-right">
                                <div class="pro-details-size w-50">
                                    <span>{{ $category->attributes()->wherePivot('is_variation', 1)->first()->name }}</span>
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
                                    <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton" value="1" data-max="5"/>
                                </div>
                                <div class="pro-details-cart">
                                    <a href="#">افزودن به سبد خرید</a>
                                </div>
                                <div class="pro-details-wishlist">
                                    <a title="Add To Wishlist" href="#"><i class="sli sli-heart"></i></a>
                                </div>
                                <div class="pro-details-compare">
                                    <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
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
                                    @foreach ($product->tags as $tag)
                                        <li><a href="#">{{ $tag->name }}</a>{{$loop->last ? '' : '،' ;}} </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="tab-content quickview-big-img">
                            <div id="primary-{{$product->id}}" class="tab-pane fade show active">
                                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}" alt="" />
                            </div>
                            @foreach ($product->productImages as $productImage)
                            <div id="other-{{$productImage->id}}" class="tab-pane fade">
                                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$productImage->image)}}" alt="" />
                            </div>
                            @endforeach

                        </div>
                        <!-- Thumbnail Large Image End -->
                        <!-- Thumbnail Image End -->
                        <div class="quickview-wrap mt-15">
                            <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                <a class="active" data-toggle="tab" href="#primary-{{$product->id}}">
                                    <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}" alt="" />
                                </a>
                                @foreach ($product->productImages as $productImage)
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
<!-- Modal end -->
@endsection
