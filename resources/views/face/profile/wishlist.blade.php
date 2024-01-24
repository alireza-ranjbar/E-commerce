@extends('face.layouts.face')
@section('title','profile')

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
                                <div class="tab-pane fade show active" id="wishlist" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3> لیست علاقه مندی ها </h3>
                                        <form class="mt-3" action="#">
                                            <div class="table-content table-responsive cart-table-content">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th> تصویر محصول </th>
                                                            <th> نام محصول </th>
                                                            <th> حذف </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <a href="#"><img
                                                                        src="assets/img/cart/cart-3.svg"
                                                                        alt=""></a>
                                                            </td>
                                                            <td class="product-name"><a href="#"> لورم ایپسوم
                                                                </a>
                                                            </td>
                                                            <td class="product-name">
                                                                <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <a href="#"><img
                                                                        src="assets/img/cart/cart-4.svg"
                                                                        alt=""></a>
                                                            </td>
                                                            <td class="product-name"><a href="#"> لورم ایپسوم
                                                                    متن
                                                                </a>
                                                            </td>
                                                            <td class="product-name">
                                                                <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <a href="#"><img
                                                                        src="assets/img/cart/cart-5.svg"
                                                                        alt=""></a>
                                                            </td>
                                                            <td class="product-name"><a href="#"> لورم ایپسوم
                                                                </a>
                                                            </td>
                                                            <td class="product-name">
                                                                <a href="#"> <i class="sli sli-trash" style="font-size: 20px"></i> </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
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
