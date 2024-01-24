@extends('admin.layouts.admin')

@section('title', 'Create Brand')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.brands.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="form-group col-md-9">
                    <label for="name">نام برند:</label>
                    <input type="text" name="name" class="form-control" id="name">
                </div>
                <div class="form-group col-md-3">
                    <label for="is_active">وضعیت</label>
                    <select class="form-control" id="is_active" name="is_active">
                        <option value="1" selected>فعال</option>
                        <option value="0">غیرفعال</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 d-flex justify-content-between">
            <a href="{{route('admin.brands.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-primary px-4">ثبت</button>
        </div>
    </div>


</form>

@endsection
