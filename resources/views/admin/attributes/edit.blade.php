@extends('admin.layouts.admin')

@section('title', 'Edit Attribute')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.attributes.update' , ['attribute' => $attribute->id]) }}" method="POST">
    @csrf
    @method('put')
    <div class="row ">
        <div class="col-md-8">
            <div class="row">
                    <label for="name">نام ویژگی:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$attribute->name}}">
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-8 d-flex justify-content-between">
            <a href="{{route('admin.attributes.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-info px-4">ویرایش</button>
        </div>
    </div>

</form>

@endsection
