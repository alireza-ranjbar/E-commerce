@extends('admin.layouts.admin')

@section('title', 'Edit Permission')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.permissions.update' , ['permission' => $permission->id]) }}" method="POST">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <label for="name">نام مجوز:</label>
                <input type="text" name="name" class="form-control" id="name" value="{{$permission->name}}">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 d-flex justify-content-between">
            <a href="{{route('admin.permissions.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-info px-4">ویرایش</button>
        </div>
    </div>

</form>

@endsection
