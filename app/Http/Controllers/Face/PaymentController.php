<?php

namespace App\Http\Controllers\Face;

use App\PaymentGateway\Pay;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\PaymentGateway\Zarinpal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request){
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
            'payment_method' => 'required',
        ]);

        if ($validator->fails()) {
            alert()->error('انتخاب آدرس تحویل سفارش الزامی می باشد', 'دقت کنید')->persistent('حله');
            return redirect()->back();
        }

        //check if Cart is empty or price is changed or quantity is less than order
        $checkCart = $this->checkCart();
        if (array_key_exists('error', $checkCart)) {
            alert()->error($checkCart['error'], 'دقت کنید');
            return redirect()->route('index');
        }

        //check if copoun is valid (correct code & not used previous)
        //then create a session for copoun (didnt understand...???)
        //then reurn amounts
        $amounts = $this->getAmounts();
        if (array_key_exists('error', $amounts)) {
            alert()->error($amounts['error'], 'دقت کنید');
            return redirect()->route('index');
        }

        //request to payment gate option 1
        if ($request->payment_method == 'pay') {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->send($amounts, $request->address_id);
            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                return redirect()->to($payGatewayResult['success']);
            }
        }

        //request to payment gate option 2
        if ($request->payment_method == 'zarinpal') {
            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->send($amounts, 'خرید تستی', $request->address_id);
            if (array_key_exists('error', $zarinpalGatewayResult)) {
                alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                return redirect()->to($zarinpalGatewayResult['success']);
            }
        }

        //if wrong option was selected
        alert()->error('درگاه پرداخت انتخابی اشتباه میباشد', 'دقت کنید');
        return redirect()->back();

    }

    public function paymentVerify(Request $request, $gatewayName)
    {
        if ($gatewayName == 'pay') {
            $payGateway = new Pay();
            $payGatewayResult = $payGateway->verify($request->token, $request->status);

            if (array_key_exists('error', $payGatewayResult)) {
                alert()->error($payGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                alert()->success($payGatewayResult['success'], 'با تشکر');
                return redirect()->route('index');
            }
        }

        if ($gatewayName == 'zarinpal') {
            $amounts = $this->getAmounts();
            if (array_key_exists('error', $amounts)) {
                alert()->error($amounts['error'], 'دقت کنید');
                return redirect()->route('index');
            }

            $zarinpalGateway = new Zarinpal();
            $zarinpalGatewayResult = $zarinpalGateway->verify($request->Authority, $amounts['paying_amount']);

            if (array_key_exists('error', $zarinpalGatewayResult)) {
                alert()->error($zarinpalGatewayResult['error'], 'دقت کنید')->persistent('حله');
                return redirect()->back();
            } else {
                alert()->success($zarinpalGatewayResult['success'], 'با تشکر');
                return redirect()->route('index');
            }
        }

        alert()->error('مسیر بازگشت از درگاه پرداخت اشتباه می باشد', 'دقت کنید');
        return redirect()->route('cart.checkout');
    }

    public function checkCart()
    {
        if (\Cart::isEmpty()) {
            return ['error' => 'سبد خرید شما خالی می باشد'];
        }

        foreach (\Cart::getContent() as $item) {
            $variation = ProductVariation::find($item->attributes->id);

            $price = $variation->sale_check ? $variation->sale_price : $variation->price;

            if ($item->price != $price) {
                \Cart::clear();
                return ['error' => 'قیمت محصول تغییر پیدا کرد'];
            }

            if ($item->quantity > $variation->quantity) {
                \Cart::clear();
                return ['error' => 'تعداد محصول تغییر پیدا کرد'];
            }

            return ['success' => 'success!'];
        }
    }

    public function getAmounts()
    {
        if (session()->has('coupon')) {
            //I cant understand this. why did they create session when there is a session?
            $couponResponse = couponResponse(session()->get('coupon.code'));
            if (array_key_exists('error', $couponResponse)) {
                return $couponResponse;
            }
        }

        return [
            'total_amount' => cartTotalWithoutDiscount(),
            'delivery_amount' => cartTotalDeliveryAmount(),
            'coupon_amount' => session()->has('coupon') ? session()->get('coupon.amount') : 0,
            'paying_amount' => cartTotalAmount()
        ];
    }
}
