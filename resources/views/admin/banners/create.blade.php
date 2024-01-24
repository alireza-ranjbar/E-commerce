@extends('admin.layouts.admin')

@section('title', 'Create Banner')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
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
            <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}">
        </div>

        <div class="form-group col-3">
            <label for="text">متن</label>
            <input type="text" class="form-control" name="text" id="text" value="{{old('text')}}">
        </div>

        <div class="form-group col-3">
            <label for="priority">اولویت</label>
            <input type="number" class="form-control" name="priority" id="priority" value="{{old('priority')}}">
        </div>

        <div class="form-group col-3">
            <label for="is_active">وضعیت</label>
            <select class="form-control" name="is_active" id="is_active">
                <option value="1">فعال</option>
                <option value="0">غیرفعال</option>
            </select>
        </div>

        <div class="form-group col-3">
            <label for="type">نوع</label>
            <input type="text" class="form-control" name="type" id="type" value="{{old('type')}}">
        </div>

        <div class="form-group col-3">
            <label for="button_text">متن دکمه</label>
            <input type="text" class="form-control" name="button_text" id="button_text" value="{{old('button_text')}}">
        </div>

        <div class="form-group col-3">
            <label for="button_link">لینک دکمه</label>
            <input type="text" class="form-control" name="button_link" id="button_link" value="{{old('button_link')}}">
        </div>

        <div class="form-group col-3">
            <label for="button_icon">آیکون دکمه</label>
            <input type="text" class="form-control" name="button_icon" id="button_icon" value="{{old('button_icon')}}">
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
