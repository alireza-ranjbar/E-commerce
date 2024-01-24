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
                                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>سفارشات</h3>
                                        <div class="myaccount-table table-responsive text-center">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th> سفارش </th>
                                                        <th> تاریخ </th>
                                                        <th> وضعیت </th>
                                                        <th> جمع کل </th>
                                                        <th> عملیات </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                    <tr>
                                                        <td>{{$order->id}}</td>
                                                        <td>{{verta($order->created_at)->format('%d %B %Y')}}</td>
                                                        <td>{{$order->status}}</td>
                                                        <td>
                                                            {{number_format($order->paying_amount)}}
                                                            تومان
                                                        </td>
                                                        <td><a href="#" data-toggle="modal"
                                                                data-target="#ordersDetiles-{{$order->id}}"
                                                                class="check-btn sqr-btn "> نمایش جزئیات </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

<!-- Modal Order -->
@foreach ($orders as $order)
    <div class="modal fade" id="ordersDetiles-{{$order->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
                            <form action="#">
                                <div class="table-content table-responsive cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th> تصویر محصول </th>
                                                <th> نام محصول </th>
                                                <th> فی </th>
                                                <th> تعداد </th>
                                                <th> قیمت کل </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $orderItem)
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="{{route('face.product.show',['product' => $orderItem->product->slug])}}">
                                                        <img width="100" src="{{asset(env('PRODUCT_IMAGE_UPLOAD_PATH').$orderItem->product->primary_image)}}" alt=""></a>
                                                </td>
                                                <td class="product-name"><a href="{{route('face.product.show',['product' => $orderItem->product->slug])}}">{{$orderItem->product->name}}</a></td>
                                                <td class="product-price-cart"><span class="amount">
                                                        {{number_format($orderItem->price)}}
                                                        تومان
                                                    </span></td>
                                                <td class="product-quantity">
                                                    {{$orderItem->quantity}}
                                                </td>
                                                <td class="product-subtotal">
                                                    {{number_format($orderItem->subtotal)}}
                                                    تومان
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
<!-- Modal end -->
@endsection
