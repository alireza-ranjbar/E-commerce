@extends('face.layouts.face')
@section('title','compare')

@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html"> صفحه ای اصلی </a>
                </li>
                <li class="active"> مقایسه محصول </li>
            </ul>
        </div>
    </div>
</div>

<!-- compare main wrapper start -->
<div class="compare-page-wrapper pt-100 pb-100" style="direction: rtl;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Compare Page Content Start -->
                <div class="compare-page-content-wrap">
                    <div class="compare-table table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="first-column"> محصول </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="product-image-title">
                                        <a href="{{route('face.product.show' , ['product' => $compareProduct->slug])}}" class="image">
                                            <img class="img-fluid" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$compareProduct->primary_image)}}"
                                                alt="{{ $compareProduct->slug }}">
                                        </a>
                                        <a href="{{route('face.categories.show' , ['category' => $compareProduct->category->slug])}}" class="category"> {{$compareProduct->category->name}} </a>
                                        <a href="{{route('face.product.show' , ['product' => $compareProduct->slug])}}" class="title">{{$compareProduct->name}}</a>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> توضیحات </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="pro-desc">
                                        <p class="text-right">{{$compareProduct->description}}</p>
                                    </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td class="first-column"> ویژگی متغیر </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="pro-color">{{$compareProduct->category->attributes()->wherePivot('is_variation',1)->first()->name}}:
                                        <ul>
                                        @foreach ($compareProduct->productVariations()->where('quantity','>',0)->get() as $produvtVariation)
                                            <li>
                                            <span>- {{$produvtVariation->value}}</span>
                                            </li>
                                        @endforeach
                                        </ul>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> ویژگی </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="pro-stock">
                                        @foreach ($compareProduct->category->attributes()->wherePivot('is_filter',1)->get() as $attribute)
                                        {{$attribute->name}}: {{$compareProduct->productAttributes()->where('attribute_id',$attribute->id)->first()->value}}@if(!$loop->last)،<br> @endif
                                        @endforeach
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> امتیاز </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="pro-ratting">
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                        <i class="sli sli-star"></i>
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class="first-column"> حذف </td>
                                    @foreach ($compareProducts as $compareProduct)
                                    <td class="pro-remove">
                                        <a href="{{route('compare.remove', ['product' => $compareProduct->id])}}"><i class="sli sli-trash"></i></a>
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Compare Page Content End -->
            </div>
        </div>
    </div>
</div>
<!-- compare main wrapper end -->
@endsection
