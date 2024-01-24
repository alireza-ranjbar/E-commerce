@extends('admin.layouts.admin')

@section('title', 'Create Coupon')

@section('script')
    <script>
        jalaliDatepicker.startWatch();

    </script>
@endsection

@section('content')

@include('admin.sections.errors')

<form action="{{ route('admin.coupons.store') }}" method="POST">
    @csrf
    <div class="row">

            <div class="form-group col-3">
                <label for="name">نام</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="form-group col-3">
                <label for="code">کد</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
            </div>

            <div class="form-group col-3">
                <label for="type">نوع</label>
                <select name="type" id="type" class="form-control">
                    <option value="amount">مبلغی</option>
                    <option value="percentage">درصدی</option>
                </select>
            </div>

            <div class="form-group col-3">
                <label for="amount">مبلغ</label>
                <input type="text" name="amount" id="amount" class="form-control" value="{{ old('amount') }}">
            </div>

            <div class="form-group col-3">
                <label for="percentage">درصد</label>
                <input type="text" name="percentage" id="percentage" class="form-control" value="{{ old('percentage') }}">
            </div>

            <div class="form-group col-3">
                <label for="max_percentage_amount">حداکثر مبلغ</label>
                <input type="text" name="max_percentage_amount" id="max_percentage_amount" class="form-control" value="{{ old('max_percentage_amount') }}">
            </div>

            <div class="form-group col-3">
                <label for="expired_at">تاریخ انقضا</label>
                <input type="text" name="expired_at" id="expired_at" class="form-control" value="{{ old('expired_at')}}" data-jdp>
            </div>

            <div class="form-group col-md-12">
                <label for="description">توضیحات</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="col">
                <button type="submit" class="btn btn-primary">ثبت</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-dark">بازگشت</a>
            </div>

    </div>
</form>

@endsection
