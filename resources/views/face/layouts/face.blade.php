<!DOCTYPE html>
<html class="no-js" lang="fa">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('/css/face.css')}}" />
    @yield('style')

</head>

<body>
    <div class="wrapper text-center">

        <div id="overlayer"></div>
        <span class="loader">
            <span class="loader-inner"></span>
        </span>

        @include('face.sections.header')

        @include('face.sections.mobile-canvas')

        @yield('content')

        @include('face.sections.footer')

    </div>
    <!-- All JS is here
============================================ -->

    <!-- jQuery JS -->
    <script src="{{asset('/js/face/jquery-1.12.4.min.js')}}"></script>
    <!-- Plugins JS -->
    <script src="{{asset('/js/face/plugins.js')}}"></script>
    <!-- Ajax Mail -->
    <script src="{{asset('js/face/ajax-mail.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('/js/face.js')}}"></script>

    @yield('script')
    @include('sweet::alert')

    <script>
        $(window).load(function() {
            $(".loader").delay(2000).fadeOut("slow");
            $("#overlayer").delay(2000).fadeOut("slow");
        })
    </script>

    {!! GoogleReCaptchaV3::init() !!}

</body>

</html>
