@extends('admin.layouts.admin')

@section('title', 'Show Product')

@section('content')


<div class="row">

    <div class="form-group col-3">
        <label for="name">نام محصول</label>
        <input type="text" name="name" id="name" class="form-control" value="{{$product->name}}" disabled>
    </div>

    <div class="form-group col-3">
        <label>برند</label>
        <input type="text" class="form-control" value="{{$product->brand->name}}" disabled>
    </div>

    <div class="form-group col-3">
        <label>وضعیت</label>
        <input type="text" class="form-control" value="{{$product->is_active}}" disabled>
    </div>

    <div class="form-group col-3">
        <label>تگ ها</label>
        <input type="text" class="form-control"
        value="@foreach ($product->tags as $tag){{$tag->name}}{{$loop->last?'':','}}@endforeach" disabled>
    </div>

    <div class="form-group col-3">
        <label>دسته بندی</label>
        <input type="text" class="form-control" value="{{$product->category->name}}" disabled>
    </div>

    <div class="form-group col-3">
        <label>تاریخ ایجاد</label>
        <input type="text" class="form-control" value="{{verta($product->created_at)}}" disabled>
    </div>

    <div class="form-group col-12">
        <label>توضیحات</label>
        <textarea class="form-control" disabled>{{$product->description}}</textarea>
    </div>

    {{-- show filter attributes --}}
    <div class="col-12 mb-3">
        <hr>
        <h5>ویژگی های فیلتر</h5>
    </div>
    @foreach ($product->productAttributes()->with('attribute')->get() as $productAttribute)
    <div class="form-group col-3">
        <label>{{$productAttribute->attribute->name}}</label>
        <input type="text" class="form-control" value="{{$productAttribute->value}}" disabled>
    </div>
    @endforeach

    {{-- show variation attribute --}}
    <div class="col-12 mb-3">
        <hr>
        <h5>روش یک: متغیرهای ویژگی {{$product->category->attributes()->wherePivot('is_variation',1)->first()->name}}</h5>
        <h5>روش دو: متغیرهای ویژگی {{$product->productVariations()->first()->attribute->name}}</h5>
    </div>
    @foreach ($product->productVariations as $productVariation)

        <div class="col-12 d-flex justify-content-start align-items-center my-2">
            <h5 class="me-5">متغیر {{$productVariation->value}}</h5>
            <button class="btn btn-sm btn-primary mr-2" data-toggle="collapse" data-target="#collapse-{{$productVariation->id}}">
            نمایش
            </button>
        </div>

        <div class="collapse col-12" id="collapse-{{$productVariation->id}}">
            <div class="card card-body">
                <div class="row">
                    <div class="form-group col-3">
                        <label>قیمت</label>
                        <input type="text" class="form-control" value="{{$productVariation->price}}" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>تعداد</label>
                        <input type="text" class="form-control" value="{{$productVariation->quantity}}" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>شناسه انبار</label>
                        <input type="text" class="form-control" value="{{$productVariation->sku}}" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>قیمت حراجی</label>
                        <input type="text" class="form-control" value="{{$productVariation->sale_price}}" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>تاریخ آغاز حراجی</label>
                        <input type="text" class="form-control" value="{{$productVariation->date_on_sale_from}}" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>تاریخ پایان حراجی</label>
                        <input type="text" class="form-control" value="{{$productVariation->date_on_sale_to}}" disabled>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

    {{-- show delivery costs --}}
    <div class="col-12 mb-3">
        <hr>
        <h5>هزینه ارسال</h5>
    </div>
    <div class="form-group col-3">
        <label>هزینه ارسال</label>
        <input type="text" class="form-control" value="{{$product->delivery_amount}}" disabled>
    </div>
    <div class="form-group col-3">
        <label>هزینه ارسال برای محصول اضافی</label>
        <input type="text" class="form-control" value="{{$product->delivery_amount_per_product}}" disabled>
    </div>

    {{-- show images --}}
    <div class="col-12 mb-3">
        <hr>
        <h5>تصاویر محصول</h5>
    </div>
    <div class="row">
        <div class="form-group col-3">
            <div class="card">
                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$product->primary_image)}}" class="card-img-top" alt="{{$product->name}}">
            </div>
            <div class="card-body">
                <h6 class="card-title">تصویر اصلی</h6>
            </div>
        </div>

        @foreach ($product->productImages as $productImage)
        <div class="form-group col-3">
            <div class="card">
                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$productImage->image)}}" class="card-img-top" alt="{{$product->name}}">
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <a href="{{route('admin.products.index')}}" class="btn btn-dark mr-3">بازگشت</a>
    </div>


</div>





@endsection
