@extends('admin.layouts.admin')

@section('title', 'Users')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>کاربران ({{$users->total()}})</h5>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                        <tr>
                            <th>{{ $users->firstItem() + $key }}</th>
                            <td>{{ $user->name }}</td>
                            <td>
                                <a href="{{route('admin.users.edit' , ['user' => $user->id])}}"
                                    class="btn btn-outline-info">ویرایش کاربر</a>
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
    {{$users->links()}}
</div>

@endsection
