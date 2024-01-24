@extends('face.layouts.face')
@section('title','Profile')

@section('script')
<script>
    $('.province-select').change(function() {

        var provinceID = $(this).val();

        if (provinceID) {
            $.ajax({
                type: "GET",
                url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                success: function(res) {
                    if (res) {
                        $(".city-select").empty();
                        $.each(res, function(key, city) {
                            $(".city-select").append('<option value="' + city.id + '">' +
                                city.name + '</option>');
                        });

                    } else {
                        $(".city-select").empty();
                    }
                }
            });
        } else {
            $(".city-select").empty();
        }
    });
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
                <li class="active"> پروفایل </li>
            </ul>
        </div>
    </div>
</div>

<!-- my account wrapper start -->
<div class="my-account-wrapper pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <div class="row text-right" style="direction: rtl;">
                        <!-- My Account Tab Menu Start -->
                        <div class="col-lg-3 col-md-4">
                            @include('face.sections.profile-sidebar')
                        </div>
                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">

                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade show active" id="address" role="tabpanel">
                                    <div class="myaccount-content address-content">
                                        <h3> آدرس ها </h3>
                                        @foreach ($addresses as $address)
                                        <div class="mt-3">
                                            <address>
                                                <p>
                                                    <strong>{{auth()->user()->name}}</strong>
                                                    <span class="mr-2"> عنوان آدرس : <span> {{$address->title}} </span> </span>
                                                </p>
                                                <p>
                                                    {{$address->address}}
                                                    <br>
                                                    <span> استان : {{App\Models\Province::findOrFail($address->province_id)->name}} </span>
                                                    <span> شهر : {{App\Models\City::findOrFail($address->city_id)->name}} </span>
                                                </p>
                                                <p>
                                                    کدپستی :
                                                    {{$address->postal_code}}
                                                </p>
                                                <p>
                                                    شماره موبایل :
                                                    {{$address->cellphone}}
                                                </p>

                                            </address>
                                            <a data-toggle="collapse" href="#edit-form-{{$address->id}}">
                                                <i class="sli sli-pencil"></i>
                                                ویرایش آدرس
                                            </a>

                                            <div id="edit-form-{{$address->id}}">

                                                <form action="{{route('profile.address.update',['address' => $address->id])}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>عنوان</label>
                                                            <input type="text" name="title" value="{{$address->title}}">
                                                            @error('title','updating-'.$address->id)
                                                            <p class="input-error-validation">{{$message}}</p>
                                                            @enderror
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                شماره تماس
                                                            </label>
                                                            <input type="text" name="cellphone" value="{{$address->cellphone}}">
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>استان</label>
                                                            <select class="email s-email s-wid province-select" name="province_id">
                                                                @foreach ($provinces as $province)
                                                                <option value="{{$province->id}}" {{$province->id == $address->province_id ? 'selected' : ''}}>{{$province->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                شهر
                                                            </label>
                                                            <select class="email s-email s-wid city-select" name="city_id">
                                                                <option value="{{$address->city_id}}">{{App\Models\City::findOrFail($address->city_id)->name}}</option>
                                                            </select>
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                آدرس
                                                            </label>
                                                            <input type="text" name="address" value="{{$address->address}}">
                                                        </div>
                                                        <div class="tax-select col-lg-6 col-md-6">
                                                            <label>
                                                                کد پستی
                                                            </label>
                                                            <input type="text" name="postal_code" value="{{$address->postal_code}}">
                                                        </div>

                                                        <div class=" col-lg-12 col-md-12">
                                                            <button class="cart-btn-2" type="submit"> ویرایش
                                                                آدرس
                                                            </button>
                                                        </div>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>
                                        <hr>
                                        @endforeach

                                        <button type="button" data-toggle="collapse" data-target="#store-form" class="mt-3"> ایجاد آدرس  جدید </button>
                                        <div class="collapse {{ count($errors->storing)>0 ? 'collapse show' : '' }}" id="store-form">
                                            <form action="{{route('profile.address.store')}}" method="POST">
                                                @csrf
                                                <div class="row">

                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            عنوان
                                                        </label>
                                                        <input type="text" name="title" value="{{old('title')}}">
                                                        @error('title' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            شماره تماس
                                                        </label>
                                                        <input type="text" name="cellphone" value="{{old('title')}}">
                                                        @error('cellphone' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            استان
                                                        </label>
                                                        <select class="email s-email s-wid province-select" name="province_id">
                                                            @foreach ($provinces as $province)
                                                            <option value="{{$province->id}}">{{$province->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('province_id' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            شهر
                                                        </label>
                                                        <select class="email s-email s-wid city-select" name="city_id">
                                                            {{-- TODO --}}
                                                        </select>
                                                        @error('city_id' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            آدرس
                                                        </label>
                                                        <input type="text" name="address" value="{{old('address')}}">
                                                        @error('address' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>
                                                    <div class="tax-select col-lg-6 col-md-6">
                                                        <label>
                                                            کد پستی
                                                        </label>
                                                        <input type="text" name="postal_code" value="{{old('postal_code')}}">
                                                        @error('postal_code' , 'storing')
                                                            <p class="input-error-validation">{{$message}}</p>
                                                        @enderror
                                                    </div>

                                                    <div class=" col-lg-12 col-md-12">
                                                        <button class="cart-btn-2" type="submit">ثبت آدرس</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Tab Content End -->
                    </div>
                </div>
                <!-- My Account Page End -->
            </div>
        </div>
    </div>
</div>
<!-- my account wrapper end -->

@endsection
