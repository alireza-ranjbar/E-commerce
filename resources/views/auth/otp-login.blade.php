@extends('face.layouts.face')
@section('title','login')

@section('script')
<script>
    $('#checkOTPForm').hide();
    $('#resendOTPButton').hide();


    let loginToken;
    $('#loginForm').submit(function(event){
        event.preventDefault();

        $.post("{{ url('/otp-login') }}",
        {
            '_token' : "{{ csrf_token() }}",
            'cellphone' : $('#cellphoneInput').val()

        } , function(response , status){
            //console.log(response , status); //not neccessary????
            loginToken = response.login_token; //why didnt use loginToken hereafer??????

            swal({                   //next expalin
                icon : 'success',
                text: 'رمز یکبار مصرف برای شما ارسال شد',
                button : 'حله!',
                timer : 2000
            });

            $('#loginForm').fadeOut();
            $('#checkOTPForm').fadeIn();
            timer();                 //next expalin

        }).fail(function(response){
            console.log(response.responseJSON); //not neccessary????
            $('#cellphoneInput').addClass('mb-1');
            $('#cellphoneInputError').fadeIn();
            $('#cellphoneInputErrorText').html(response.responseJSON.errors.cellphone[0]); //next expalin
        })
    });

    $('#checkOTPForm').submit(function(event){
        event.preventDefault();

        $.post("{{ url('/check-otp') }}",
        {
            '_token' : "{{ csrf_token() }}",
            'otp' : $('#checkOTPInput').val(),
            'login_token' : loginToken

        } , function(response , status){
            console.log(response , status); // not necessary
            $(location).attr('href' , "{{ route('index') }}");

        }).fail(function(response){
            console.log(response.responseJSON);
            $('#checkOTPInput').addClass('mb-1');
            $('#checkOTPInputError').fadeIn();
            $('#checkOTPInputErrorText').html(response.responseJSON.errors.otp[0]);
        })
    });

    $('#resendOTPButton').click(function(event){
    event.preventDefault();

    $.post("{{ url('/resend-otp') }}",
        {
            '_token' : "{{ csrf_token() }}",
            'login_token' : loginToken

        } , function(response , status){
            console.log(response , status);
            loginToken = response.login_token;

            swal({
                icon : 'success',
                text: 'رمز یکبار مصرف برای شما ارسال شد',
                button : 'حله!',
                timer : 2000
            });

            $('#resendOTPButton').fadeOut();
            timer();
            $('#resendOTPTime').fadeIn();

        }).fail(function(response){
            console.log(response.responseJSON);
            swal({
                icon : 'error',
                text: 'مشکل در ارسال دوباره رمز یکبار مصرف، مجددا تلاش کنید',
                button : 'حله!',
                timer : 2000
            });
        })
    });

    function timer() {
        let time = "1:01";
        let interval = setInterval(function() {
            let countdown = time.split(':');
            let minutes = parseInt(countdown[0], 10);
            let seconds = parseInt(countdown[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) {
                clearInterval(interval);
                $('#resendOTPTime').hide();
                $('#resendOTPButton').fadeIn();
            };
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            $('#resendOTPTime').html(minutes + ':' + seconds);
            time = minutes + ':' + seconds;
        }, 1000);
    }
</script>
@endsection


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
                            <h4> ورود یا عضویت با شماره همراه </h4>
                        </a>
                    </div>
                    <div class="tab-content">

                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form id="loginForm" action="{{route('otplogin')}}" method="post">
                                        @csrf

                                        <input id="cellphoneInput" type="tell" name="cellphone" placeholder="شماره تلفن" value="{{old('cellphone')}}">

                                        <div id="cellphoneInputError" class="input-error-validation">
                                            <strong id="cellphoneInputErrorText"></strong>
                                        </div>

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
                                    <form id="checkOTPForm">
                                        <input id="checkOTPInput" placeholder="رمز یکبار مصرف" type="text">

                                        <div id="checkOTPInputError" class="input-error-validation">
                                            <strong id="checkOTPInputErrorText"></strong>
                                        </div>

                                        <div class="button-box d-flex justify-content-between">
                                            <button type="submit">ورود</button>
                                            <div>
                                                <button id="resendOTPButton" type="submit">ارسال مجدد</button>
                                                <span id="resendOTPTime"></span>
                                            </div>
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


