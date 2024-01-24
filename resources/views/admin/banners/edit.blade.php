@extends('admin.layouts.admin')

@section('title', 'Edit Banner')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.banners.update' , ['banner' => $banner->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')

    <h5>ویرایش بنر: {{$banner->title}}</h5>
    <div class="row justify-content-center">
        <div class="form-group col-4">
            <div class="card">
                <img src="{{url(env('BANNER_IMAGE_UPLOAD_PATH').$banner->image)}}" class="card-img-top" alt="{{$banner->name}}">
            </div>
            <div class="card-body">
                <p class="card-title"><small>{{$banner->image}}</small></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="from-group col-3">
            <label>تصویر</label>
            <div class="custom-file">
                <label class="custom-file-label" for="image">یک تصویر انتخاب کنید</label>
                <input type="file" class="custom-file-input" name="image" id="image">
            </div>
        </div>

        <div class="from-group col-3">
            <label for="title">عنوان</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$banner->title}}">
        </div>

        <div class="form-group col-3">
            <label for="text">متن</label>
            <input type="text" class="form-control" name="text" id="text" value="{{$banner->text}}">
        </div>

        <div class="form-group col-3">
            <label for="priority">اولویت</label>
            <input type="number" class="form-control" name="priority" id="priority" value="{{$banner->priority}}">
        </div>

        <div class="form-group col-3">
            <label for="is_active">وضعیت</label>
            <select class="form-control" name="is_active" id="is_active">
                <option value="1" {{$banner->getRawOriginal('is_active') ? 'selected' : ''}}>فعال</option>
                <option value="0" {{$banner->getRawOriginal('is_active') ? '' : 'selected'}}>غیرفعال</option>
            </select>
        </div>

        <div class="form-group col-3">
            <label for="type">نوع</label>
            <input type="text" class="form-control" name="type" id="type" value="{{$banner->type}}">
        </div>

        <div class="form-group col-3">
            <label for="button_text">متن دکمه</label>
            <input type="text" class="form-control" name="button_text" id="button_text" value="{{$banner->button_text}}">
        </div>

        <div class="form-group col-3">
            <label for="button_link">لینک دکمه</label>
            <input type="text" class="form-control" name="button_link" id="button_link" value="{{$banner->button_link}}">
        </div>

        <div class="form-group col-3">
            <label for="button_icon">آیکون دکمه</label>
            <input type="text" class="form-control" name="button_icon" id="button_icon" value="{{$banner->button_icon}}">
        </div>
    </div>

    <div class="row mt-3">
        <div class="ml-3">
            <a href="{{route('admin.banners.index')}}" class="btn btn-outline-dark">بازگشت</a>
        </div>
        <button type="submit" class="btn btn-primary px-4">ثبت</button>
    </div>


</form>

@endsection
