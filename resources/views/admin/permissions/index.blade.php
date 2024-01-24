@extends('admin.layouts.admin')

@section('title', 'Permissions')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>مجوزها ({{$permissions->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.permissions.create')}}">ایجاد مجوز</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>مجوز</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $key => $permission)
                        <tr>
                            <th>{{ $permissions->firstItem() + $key }}</th>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{route('admin.permissions.edit' , ['permission' => $permission->id])}}"
                                    class="btn btn-outline-info">ویرایش مجوز</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="d-flex justify-content-center">
    {{$permissions->links()}}
</div>

@endsection
