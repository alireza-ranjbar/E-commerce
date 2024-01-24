@extends('admin.layouts.admin')

@section('title', 'Banner')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>بنر ها ({{$banners->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.banners.create')}}">ایجاد بنر</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تصویر</th>
                            <th>عنوان</th>
                            <th>متن</th>
                            <th>اولویت</th>
                            <th>وضعیت</th>
                            <th>نوع</th>
                            <th>متن دکمه</th>
                            <th>لینک دکمه</th>
                            <th>آیکون دکمه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $key => $banner)
                        <tr>
                            <th>{{ $banners->firstItem() + $key }}</th>
                            <td><a target="_blank" href="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$banner->image)}}">{{ $banner->image }}</a></td>
                            <td>{{$banner->title}}</td>
                            <td>{{$banner->text}}</td>
                            <td>{{$banner->priority}}</td>
                            <td class="{{$banner->getRawOriginal('is_active') ? 'text-success' : 'text-danger'}}">{{$banner->is_active}}</td>
                            <td>{{$banner->type}}</td>
                            <td>{{$banner->button_text}}</td>
                            <td>{{$banner->button_link}}</td>
                            <td>{{$banner->button_icon}}</td>
                            <td class="d-flex align-items-center">
                                <form action="{{route('admin.banners.destroy',['banner' => $banner->id])}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                </form>
                                <div class="mr-2">
                                    <a href="{{route('admin.banners.edit' , ['banner' => $banner->id])}}"
                                        class="btn btn-sm btn-outline-info">ویرایش</a>
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
    {{$banners->links()}}
</div>

@endsection
