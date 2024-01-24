<?php

namespace App\Http\Controllers\Face;

use Cart;
use App\Models\Product;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(){
        return view('face.cart.show');
    }

    public function add(Product $product,Request $request){

        $request->validate([
            'variationId' => 'required',
            'qtybutton' => 'required'
        ]);
        $variation = ProductVariation::find($request->variationId);

        if($request->qtybutton > $variation->quantity){
            alert()->warning('The selected quantity is not correct.','Ooops');
            return redirect()->back();
        }

        $rowId = $product->id.'-'.$variation->id;
        if(Cart::get($rowId) == null){
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $variation->saleCheck ? $variation->sale_price : $variation->price,
                'quantity' => $request->qtybutton,
                'attributes' => $variation->toArray(),
                'associatedModel' => $product
            ));
        }else{
            alert()->warning('This product is alraedy added to your cart.','No No');
            return redirect()->back();
        }


        alert()->success('The product was added to your cart','Success');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'qtybutton' => 'required'
        ]);

        foreach ($request->qtybutton as $rowId => $quantity) {

            $item = Cart::get($rowId);

            if ($quantity > $item->attributes->quantity) {
                alert()->error('تعداد وارد شده از محصول درست نمی باشد', 'دقت کنید');
                return redirect()->back();
            }

            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                ),
            ));
        }

        alert()->success('سبد خرید شما ویرایش شد', 'باتشکر');
        return redirect()->back();
    }

    public function remove($rowId){
        Cart::remove($rowId);

        alert()->warning('The product was removed from cart','Done!');
        return redirect()->back();
    }

    public function clear(){
        Cart::clear();

        alert()->warning('Your cart was cleared.','Done!');
        return redirect()->route('index');
    }

    public function checkCoupon(Request $request){
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $result = couponResponse($request->coupon_code);
        // dd($result);

        if (array_key_exists('error', $result)) {
            alert()->error($result['error'], 'دقت کنید');
        } else {
            alert()->success($result['success'], 'باتشکر');
        }
        return redirect()->back();
    }

    public function checkout(){
        $provinces = Province::all();
        $addresses = UserAddress::where('user_id',auth()->id())->get();
        return view('face.cart.checkout',compact('addresses','provinces'));
    }
}
