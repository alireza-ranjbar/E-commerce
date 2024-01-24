@extends('admin.layouts.admin')

@section('title', 'Coupons')

@section('content')

<div class="row">
    <div class="col">
        <div class="row justify-content-between">
            <h5>کوپن ها({{$coupons->total()}})</h5>
            <a class="btn btn-outline-primary mb-3 px-5" href="{{route('admin.coupons.create')}}">ایجاد کوپن</a>
        </div>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام</th>
                            <th>کد</th>
                            <th>نوع</th>
                            <th>مبلغ</th>
                            <th>درصد</th>
                            <th>حداکثر مبلغ</th>
                            <th>انقصا</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $key => $coupon)
                        <tr>
                            <th>{{ $coupons->firstItem() + $key }}</th>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->type }}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td>{{ $coupon->percentage }}</td>
                            <td>{{ $coupon->max_percentage_amount }}</td>
                            <td>{{ $coupon->expired_at }}</td>
                            <td>
                                <a href="{{route('admin.coupons.show' , ['coupon' => $coupon->id])}}"
                                    class="btn btn-outline-primary">مشاهده</a>
                                <a href="{{route('admin.coupons.edit' , ['coupon' => $coupon->id])}}"
                                    class="btn btn-outline-info">ویرایش </a>
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
    {{$coupons->links()}}
</div>

@endsection
