@extends('face.layouts.face')
@section('title','contact us')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    var map = L.map('map').setView([35.685968, 51.350055], 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = L.marker([35.685968, 51.350055]).addTo(map);

    marker.bindPopup("اینجا هستیم").openPopup();
</script>
@endsection

@section('content')

<div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="{{route('index')}}">صفحه اصلی</a>
                </li>
                <li class="active">تماس با ما </li>
            </ul>
        </div>
    </div>
</div>

<div class="contact-area pt-100 pb-100">
    <div class="container">
        <div class="row text-right" style="direction: rtl;">
            <div class="col-lg-5 col-md-6">
                <div class="contact-info-area">
                    <h2> لورم ایپسوم متن </h2>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک
                        است.
                    </p>
                    <div class="contact-info-wrap">
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-location-pin"></i>
                            </div>
                            <div class="contact-info-content">
                                <p> لورم ایپسوم متن ساختگی با تولید سادگی </p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <p><a href="#">info@example.com</a> / <a href="#">info@example.com</a></p>
                            </div>
                        </div>
                        <div class="single-contact-info">
                            <div class="contact-info-icon">
                                <i class="sli sli-screen-smartphone"></i>
                            </div>
                            <div class="contact-info-content">
                                <p style="direction: ltr;"> 0910 000 0000 / 0910 000 0000 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="contact-from contact-shadow">
                    <form action="{{route('contactUsForm')}}" method="POST">
                        @csrf
                        <input name="name" type="text" placeholder="نام شما" value="{{old('name')}}">
                        @error('name')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <input name="email" type="email" placeholder="ایمیل شما" value="{{old('email')}}">
                        @error('email')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <input name="subject" type="text" placeholder="موضوع پیام" value="{{old('subject')}}">
                        @error('subject')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <textarea name="text" placeholder="متن پیام">{{old('text')}}</textarea>
                        @error('text')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        {!! GoogleReCaptchaV3::renderField('contact_us_id','contact_us_action') !!}
                        @error('g-recaptcha-response')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                        <button class="submit" type="submit"> ارسال پیام </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="contact-map pt-100">
            <div id="map"></div>
        </div>
    </div>
</div>



@endsection
