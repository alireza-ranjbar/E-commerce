@extends('face.layouts.face')
@section('title','register')


@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                @if (request()->is('login'))
                <li> ورود </li>
                @endif
                <li> عضویت </li>

            </ul>
        </div>
    </div>
</div>

<div class="login-register-area pt-100 pb-100" style="direction: rtl;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a href="{{route('login')}}">
                            <h4> ورود </h4>
                        </a>
                        <a class="active">
                            <h4> عضویت </h4>
                        </a>
                    </div>
                    <div class="tab-content">

                        <div id="lg2" class="active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="{{ route('register') }}" method="post">
                                        @csrf

                                        <input name="name" placeholder="نام" type="name" value="{{old('name')}}">
                                        @error('name')
                                        <div class="input-error-validation">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror

                                        <input name="email" placeholder="ایمیل" type="email" value="{{old('email')}}">
                                        @error('email')
                                        <div class="input-error-validation">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror

                                        <input type="password" name="password" placeholder="رمز عبور">
                                        @error('password')
                                        <div class="input-error-validation">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror

                                        <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور">
                                        @error('password_confirmation')
                                        <div class="input-error-validation">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror

                                        <div class="button-box">
                                            <button type="submit">عضویت</button>
                                            <a href="{{route('auth.provider', ['provider' => 'google'])}}" class="btn btn-google btn-block mt-4">
                                                <i class="sli sli-social-google"></i>
                                                ایجاد اکانت با گوگل
                                            </a>
                                            <a href="{{route('otplogin')}}" class="btn btn-primary btn-block mt-2">
                                                <i class=""></i> ورود با کد یکبار مصرف
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


