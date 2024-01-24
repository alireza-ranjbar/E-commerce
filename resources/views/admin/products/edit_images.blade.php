@extends('admin.layouts.admin')

@section('title', 'Edit Product Images')

@section('script')
<script>
        $('#primary_image,#other_images').change(function() {
            $(this).next('label').html('انتخاب شد');
            $(this).next('label').css('color','green');
        });
</script>
@endsection

@section('content')
@include('admin.sections.errors')

<div class="row">

    <h5>{{$product->name}}</h5>
    <p class="mr-5">تاریخ ایجاد: {{verta($product->created_at)}}</p>

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
                <h6 class="card-title text-primary">تصویر اصلی</h6>
            </div>
        </div>

        @foreach ($product->productImages as $productImage)
        <div class="form-group col-3">
            <div class="card">
                <img src="{{url(env('PRODUCT_IMAGE_UPLOAD_PATH').$productImage->image)}}" class="card-img-top" alt="{{$product->name}}">
            </div>
            <div class="card-body">
                <form action="{{route('admin.products.images.destroy',['product' => $product->id])}}" method="post">
                    @csrf
                    @method('delete')
                    <div class="form-group">
                        <input type="hidden" name="image_id" value="{{$productImage->id}}">
                        <button type="submit" class="form-control btn btn-danger btn-sm">حذف تصویر</button>
                    </div>
                </form>
                <form action="{{route('admin.products.images.set-primary',['product' => $product->id])}}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="image_id" value="{{$productImage->id}}">
                        <button type="submit" class="form-control btn btn-primary btn-sm">تنظیم به عنوان تصویر اصلی</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>


    <div class="col-12">
        <hr>
        <h5>اضافه کردن تصاویر بیشتر</h5>
        <form action="{{route('admin.products.images.update',['product' => $product->id])}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="row">
                <div class="form-group col-4">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" name="primary_image" id="primary_image">
                        <label class="custom-file-label" for="primary_image">تصویر اصلی</label>
                    </div>
                </div>

                <div class="form-group col-4">
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" name="other_images[]" multiple id="other_images">
                        <label class="custom-file-label" for="other_images">سایر تصاویر</label>
                    </div>
                </div>

                <div class="form-group col-4">
                    <button type="submit" class="form-control btn btn-primary">ثبت</button>
                </div>

            </div>
        </form>
    </div>


    <div class="row border">
        <a href="{{route('admin.products.index')}}" class="btn btn-dark mr-3">بازگشت</a>
    </div>


</div>


@endsection
