@extends('admin.layouts.admin')

@section('title', 'Categories')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>دسته بندی ها ({{$categories->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.categories.create')}}">ایجاد دسته بندی</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>دسته بندی</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                        <tr>
                            <th>{{ $categories->firstItem() + $key }}</th>
                            <td>{{ $category->name }}</td>
                            <td class="{{ $category->getRawOriginal('is_active') ? 'text-success' : 'text-danger' }}">
                                {{ $category->is_active }}</td>
                            <td>
                                <a href="{{route('admin.categories.show' , ['category' => $category->id])}}"
                                    class="btn btn-outline-primary">مشاهده</a>
                                <a href="{{route('admin.categories.edit' , ['category' => $category->id])}}"
                                    class="btn btn-outline-info">ویرایش دسته بندی</a>
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
    {{$categories->links()}}
</div>

@endsection
