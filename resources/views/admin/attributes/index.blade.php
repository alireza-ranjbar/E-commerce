@extends('admin.layouts.admin')

@section('title', 'Attributes')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>ویژگی ها ({{$attributes->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.attributes.create')}}">ایجاد ویژگی</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>ویژگی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $key => $attribute)
                        <tr>
                            <th>{{ $attributes->firstItem() + $key }}</th>
                            <td>{{ $attribute->name }}</td>
                            <td>
                                <a href="{{route('admin.attributes.show' , ['attribute' => $attribute->id])}}"
                                    class="btn btn-outline-primary">مشاهده</a>
                                <a href="{{route('admin.attributes.edit' , ['attribute' => $attribute->id])}}"
                                    class="btn btn-outline-info">ویرایش ویژگی</a>
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
    {{$attributes->links()}}
</div>

@endsection
