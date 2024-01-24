<?php

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use Darryldecode\Cart\Cart;

if (!function_exists('generateFileName')) {
    function generateFileName($name)
    {
        $year = now()->year;
        $month = now()->month;
        $day = now()->day;
        $hour = now()->hour;
        $minute = now()->minute;
        $second = now()->second;
        $microsecond = now()->microsecond;

        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
    }
}

if (!function_exists('jalaliToGregorianFrom')) {
    function jalaliToGregorianFrom($jalali)
    {
        //when date is not set by user
        if ($jalali == null) {
            return null;
        }

        //when we are in edit or create mode
        if (strpos($jalali, "/") == false) {
            $jalaliDateAndTime = explode(" ", $jalali);
            $jalaliDate = explode("-", $jalaliDateAndTime[0]);
            $gregorianDate = verta()->getGregorian($jalaliDate[0], $jalaliDate[1], $jalaliDate[2]);
            return implode("-", $gregorianDate) . " " . $jalaliDateAndTime[1];
        } else {
            $time = "00:00:00";
            $jalaliDate = explode("/", $jalali);
            $gregorianDate = verta()->getGregorian($jalaliDate[0], $jalaliDate[1], $jalaliDate[2]);
            return implode("-", $gregorianDate) . " " . $time;
        }
    }
}

if (!function_exists('jalaliToGregorianTo')) {
    function jalaliToGregorianTo($jalali)
    {
        //when date is not set by user
        if ($jalali == null) {
            return null;
        }

        //when we are in edit or create mode
        if (strpos($jalali, "/") == false) {
            $jalaliDateAndTime = explode(" ", $jalali);
            $jalaliDate = explode("-", $jalaliDateAndTime[0]);
            $gregorianDate = verta()->getGregorian($jalaliDate[0], $jalaliDate[1], $jalaliDate[2]);
            return implode("-", $gregorianDate) . " " . $jalaliDateAndTime[1];
        } else {
            $time = "23:59:59";
            $jalaliDate = explode("/", $jalali);
            $gregorianDate = verta()->getGregorian($jalaliDate[0], $jalaliDate[1], $jalaliDate[2]);
            return implode("-", $gregorianDate) . " " . $time;
        }
    }
}

if (!function_exists('cartTotalWithoutDiscount')) {
    function cartTotalWithoutDiscount()
    {
        $sum = 0;
        foreach (\Cart::getContent() as $item) {
            $sum += ($item->attributes->price * $item->quantity);
        }
        return $sum;
    }
}

if (!function_exists('cartTotalDeliveryAmount')) {
    function cartTotalDeliveryAmount()
    {
        $sum = 0;
        foreach (\Cart::getContent() as $item) {
            $sum += $item->associatedModel->delivery_amount;
        }
        return $sum;
    }
}

if (!function_exists('cartTotalAmount')) {
    function cartTotalAmount()
    {
        if (session()->has('coupon')) {
            if (session()->get('coupon.amount') > (\Cart::getTotal() + cartTotalDeliveryAmount())) {
                return 0;
            } else {
                return (\Cart::getTotal() + cartTotalDeliveryAmount()) - session()->get('coupon.amount');
            }
        } else {
            return \Cart::getTotal() + cartTotalDeliveryAmount();
        }
    }
}

if (!function_exists('couponResponse')) {
    function couponResponse($coupon_code)
    {
        //checks if the user is logged in.
        if (!auth()->check()) {
            return ['error' => 'You are not logged in.'];
        }

        $coupon = Coupon::where('code', $coupon_code)->where('expired_at', '>', Carbon::now())->first();

        //checks the coupon validity.
        if (!$coupon) {
            return ['error' => 'کد تخفیف وارد شده وجود ندارد'];
        }

        //checks if the user hasn't used this copupon code formerly.
        if (Order::where('user_id', auth()->id())->where('coupon_id', $coupon->id)->where('payment_status', 1)->exists()) {
            return ['error' => 'شما قبلا از این کد تخفیف استفاده کرده اید'];
        }

        //calculates the amount of coupon.
        if ($coupon->getRawOriginal('type') == 'amount') {
            session()->put('coupon', ['code' => $coupon->code, 'amount' => $coupon->amount]);
        } else {
            $total = \Cart::getTotal();

            $amount = (($total * $coupon->percentage) / 100) > $coupon->max_percentage_amount ? $coupon->max_percentage_amount : (($total * $coupon->percentage) / 100);

            session()->put('coupon', ['code' => $coupon->code, 'amount' => $amount]);
        }

        return ['success' => 'کد نخفیف برای شما ثبت شد'];
    }
}
