@extends('admin.layouts.admin')

@section('title', 'Show Attribute')

@section('content')


    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md">
                    <label for="name">نام ویژگی:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$attribute->name}}" disabled>
                </div>
                <div class="col-md">
                    <label for="name">زمان ایجاد:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{verta($attribute->created_at)}}" disabled>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-10">
            <a href="{{route('admin.attributes.index')}}" class="btn btn-dark">بازگشت</a>
        </div>
    </div>


</form>

@endsection
