<?php

namespace App\Http\Controllers\Face;

use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(){
        return view('face.profile.comments');
    }
    public function store(Product $product, Request $request){

        if(!auth()->check()){
            alert()->warning('Please login first.','Ooops');
            return redirect()->back();
        }else{
            $validator = Validator::make($request->all(),[
                'text' => 'required',
                'rate' => 'required'
            ]);

            if($validator->fails()){
                return redirect()->to(url()->previous() . '#form-area')->withErrors($validator);
            }

            try {
                DB::beginTransaction();

                Comment::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'text' => $request->text,
                ]);

                ProductRates::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'rate' => $request->rate,
                ]);

                DB::commit();
            } catch (\Exception $x) {
                DB::rollBack();
                alert()->warning('The comment was not registered','Error');
                return redirect()->back();
            }

            alert()->success('Your comment was saved','OK');
            return redirect()->back();

        }



    }
}
