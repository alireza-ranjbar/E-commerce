@extends('admin.layouts.admin')

@section('title', 'Create Permission')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.permissions.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <label for="name">نام مجوز:</label>
            <input type="text" name="name" class="form-control" id="name">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3 d-flex justify-content-between">
            <a href="{{route('admin.permissions.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-primary px-4">ثبت</button>
        </div>
    </div>


</form>

@endsection
