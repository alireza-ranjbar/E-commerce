<?php

namespace App\Http\Controllers\Face;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompareController extends Controller
{
    public function show(){
        $compareProducts = Product::findOrFail(session()->get('compareProducts'));
        return view('face.compare.show' , compact('compareProducts'));
    }

    public function add(Product $product){

        if(session()->get('compareProducts')){
            if(in_array($product->id, session()->get('compareProducts'))){
                alert()->warning('This product is already added to compare.', 'Hey friend!');
                return redirect()->back();
            }else{
                session()->push('compareProducts', $product->id);
            }
        }else{
            session()->put('compareProducts',[$product->id]);
        }

        alert()->success('The product was added to compare sucessfully' , 'Right!');
        return redirect()->back();

    }

    public function remove(Product $product){
        if(in_array($product->id , session()->get('compareProducts'))){


            $key = array_search($product->id,session()->get('compareProducts'));
            session()->pull('compareProducts.'.$key);

            if(empty(session('compareProducts'))){
                return redirect()->route('index');
            }else{
                alert()->warning('The product was removed from comparision.','Ok');
                return redirect()->back();
            }


        }


    }
}
