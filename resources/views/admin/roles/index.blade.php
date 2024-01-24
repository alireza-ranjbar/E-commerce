@extends('admin.layouts.admin')

@section('title', 'Roles')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>نقش ها ({{$roles->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.roles.create')}}">ایجاد نقش</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نقش</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                        <tr>
                            <th>{{ $roles->firstItem() + $key }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{route('admin.roles.edit' , ['role' => $role->id])}}"
                                    class="btn btn-outline-info">ویرایش نقش</a>
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
    {{$roles->links()}}
</div>

@endsection
