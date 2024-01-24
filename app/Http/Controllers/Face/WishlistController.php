<?php

namespace App\Http\Controllers\Face;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index(){
        return view('face.profile.wishlist');
    }
    public function add(Product $product){
        if(auth()->check()){
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ]);

            alert()->success('The product was added to your wishlist.','OK');
            return redirect()->back();
        }else{
            alert()->warning('You need to login before this.','Login');
            return redirect()->back();
        }
    }

    public function remove(Product $product){
        $wishItem = auth()->user()->wishlist()->where('product_id',$product->id);
        $wishItem->delete();
        alert()->warning('The product was removed from your wishlist','OK');
        return redirect()->back();
    }
}
