<?php

namespace App\Http\Controllers\Face;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaceProductController extends Controller
{
    public function show(Product $product){
        return view('face.products.show' , compact('product'));
    }
}
