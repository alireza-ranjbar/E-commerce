@extends('admin.layouts.admin')

@section('title', 'Show Brand')

@section('content')


    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">نام برند:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$brand->name}}" disabled>
                </div>
                <div class="col-md-2">
                    <label for="name">وضعیت:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$brand->is_active}}" disabled>
                </div>
                <div class="col-md-4">
                    <label for="name">زمان ایجاد:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{verta($brand->created_at)}}" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-10">
            <a href="{{route('admin.brands.index')}}" class="btn btn-dark">بازگشت</a>
        </div>
    </div>


</form>

@endsection
