@extends('admin.layouts.admin')

@section('title', 'Edit Role')

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.roles.update' , ['role' => $role->id]) }}" method="POST">
    @csrf
    @method('put')
    <div class="row ">
        <div class="col-md-3">
            <div class="row">
                    <label for="name">نام نقش:</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{$role->name}}">
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="accordion col-md-12" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse"
                            data-target="#collapsePermissions" aria-expanded="true" aria-controls="collapsePermissions">
                            مجوزها
                        </button>
                    </h2>
                </div>

                <div id="collapsePermissions" class="collapse show" aria-labelledby="headingOne"
                    data-parent="#accordionExample">
                    <div class="card-body row">
                        @foreach ($permissions as $permission)
                        <div class="form-group form-check col-md-2" dir="ltr">
                            <input class="form-check-input" type="checkbox" name="{{$permission->name}}"
                            value="{{$permission->name}}" id="{{$permission->id}}" {{in_array($permission->id, $role->permissions()->pluck('id')->toArray()) ? 'checked':''}}>
                            <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-3 d-flex justify-content-between">
            <a href="{{route('admin.roles.index')}}" class="btn btn-outline-dark">بازگشت</a>
            <button type="submit" class="btn btn-info px-4">ویرایش</button>
        </div>
    </div>

</form>

@endsection
