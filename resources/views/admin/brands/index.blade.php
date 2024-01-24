@extends('admin.layouts.admin')

@section('title', 'Brands')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>برندها ({{$brands->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.brands.create')}}">ایجاد برند</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>برند</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $key => $brand)
                        <tr>
                            <th>{{ $brands->firstItem() + $key }}</th>
                            <td>{{ $brand->name }}</td>
                            <td class="{{ $brand->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $brand->is_active }}</td>
                            <td>
                                <a href="{{route('admin.brands.show' , ['brand' => $brand->id])}}"
                                    class="btn btn-outline-primary">مشاهده</a>
                                <a href="{{route('admin.brands.edit' , ['brand' => $brand->id])}}"
                                    class="btn btn-outline-info">ویرایش برند</a>
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
    {{$brands->links()}}
</div>

@endsection
