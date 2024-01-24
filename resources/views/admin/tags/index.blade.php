@extends('admin.layouts.admin')

@section('title', 'Tags')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>تگ ها ({{$tags->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.tags.create')}}">ایجاد تگ</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تگ</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $key => $tag)
                        <tr>
                            <th>{{ $tags->firstItem() + $key }}</th>
                            <td>{{ $tag->name }}</td>
                            <td>
                                <a href="{{route('admin.tags.show' , ['tag' => $tag->id])}}"
                                    class="btn btn-outline-primary">مشاهده</a>
                                <a href="{{route('admin.tags.edit' , ['tag' => $tag->id])}}"
                                    class="btn btn-outline-info">ویرایش تگ</a>
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
    {{$tags->links()}}
</div>

@endsection
