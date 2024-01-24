@extends('admin.layouts.admin')

@section('title', 'Edit User')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.users.update' , ['user' => $user->id]) }}" method="POST">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">نام کاربر:</label>
                <input type="text" name="name" disabled class="form-control" id="name" value="{{$user->name}}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="exampleFormControlSelect1">نقش ها</label>
                <select class="form-control" id="exampleFormControlSelect1" name="role">
                    <option>انتخاب نقش</option>
                    @foreach ($roles as $role)
                    <option value="{{$role->name}}" {{in_array($role->id,$user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 d-flex justify-content-between">
            <a href="{{route('admin.users.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-info px-4">ویرایش</button>
        </div>
    </div>

</form>

@endsection
