@extends('admin.layouts.admin')

@section('title', 'products')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>محصولات ({{$products->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.products.create')}}">ایجاد محصول</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام محصول</th>
                            <th>برند</th>
                            <th>دسته</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $key => $product)
                        <tr>
                            <th>{{ $products->firstItem() + $key }}</th>
                            <td><a href="{{ route('admin.products.show', ['product' => $product->id]) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->brand->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="{{ $product->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $product->is_active }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                      عملیات
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="{{ route('admin.products.edit' , ['product' => $product->id]) }}">ویرایش محصول</a>
                                      <a class="dropdown-item" href="{{ route('admin.products.images.edit' , ['product' => $product->id]) }}">ویرایش تصاویر</a>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="d-flex justify-content-center">
    {{$products->links()}}
</div>

@endsection
