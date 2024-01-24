@extends('face.layouts.face')
@section('title','login')


@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="index.html">صفحه ای اصلی</a>
                </li>
                <li class=""> ورود </li>
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
                        <a class="active">
                            <h4> ورود </h4>
                        </a>
                        <a href="{{route('register')}}">
                            <h4> عضویت </h4>
                        </a>
                    </div>
                    <div class="tab-content">

                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="{{route('login')}}" method="post">
                                        @csrf

                                        <input type="email" name="email" placeholder="ایمیل" value="{{old('email')}}">
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

                                        <div class="button-box">
                                            <div class="login-toggle-btn d-flex justify-content-between">
                                                <div>
                                                    <input type="checkbox">
                                                    <label> مرا بخاطر بسپار </label>
                                                </div>
                                                <a href="register.html"> فراموشی رمز عبور ! </a>
                                            </div>
                                            <button type="submit">ورود</button>
                                            <a href="{{route('auth.provider', ['provider' => 'google'])}}" class="btn btn-danger btn-block mt-2">
                                                <i class="sli sli-social-google"></i> ورود با حساب گوگل
                                            </a>

                                        </div>
                                    </form>
                                    <a href="{{route('otplogin')}}" class="btn btn-primary btn-block mt-2">
                                        <i class=""></i> ورود با کد یکبار مصرف
                                    </a>
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


