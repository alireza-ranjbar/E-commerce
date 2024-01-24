@extends('admin.layouts.admin')

@section('title', 'Show Category')

@section('content')


<div class="row">

    <div class="form-group col-3">
        <label for="name">نام</label>
        <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}" disabled>
    </div>

    <div class="form-group col-3">
        <label for="slug">نام انگلیسی</label>
        <input type="text" name="slug" id="slug" class="form-control" value="{{$category->slug}}" disabled>
    </div>

    <div class="form-group col-3">
        <label for="parent_id">دسته والد</label>
        <input type="text" id="parent_id" class="form-control" value="{{$category->parent_id != 0 ? $category->parent->name : 'بدون والد' }}" disabled>
    </div>

    <div class="form-group col-3">
        <label for="is_active">وضعیت</label>
        <select name="is_active" id="is_active" class="form-control">
            <option value="1" selected>فعال</option>
            <option value="0">غیرفعال</option>
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="description">توضیحات</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="form-group col-3">
        <label for="attribute_ids">ویژگی</label>
        <input type="text" id="attribute_ids" class="form-control" disabled
        value="@foreach ($category->attributes()->pluck('name') as $attribute){{$attribute}}{{$loop->last ? '' : '، '}}@endforeach">
    </div>

    <div class="form-group col-3">
        <label for="filter_attribute_ids">ویژگی قابل فیلتر</label>
        <input type="text" id="filter_attribute_ids" class="form-control" disabled
        value="@foreach ($category->attributes()->where('is_filter',1)->get() as $attribute){{$attribute->name}}{{$loop->last ? '' : '، '}}@endforeach">
    </div>

    <div class="form-group col-3">
        <label for="variation_attribute_id">ویژگی متغیر</label>
        <input type="text" id="variation_attribute_id" class="form-control" disabled
        value="{{$category->attributes()->where('is_variation',1)->value('name')}}">
    </div>

    <div class="form-group col-3">
        <label for="icon">آیکون</label>
        <input type="text" id="icon" class="form-control" value="{{ $category->icon }}" disabled>
    </div>

    <div class="col">
        <button type="submit" class="btn btn-primary">ثبت</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">بازگشت</a>
    </div>

</div>





@endsection
