<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function store($product , $attributes){
        foreach($attributes as $key => $attribute){
            ProductAttribute::create([
                'attribute_id' => $key,
                'product_id' => $product->id,
                'value' => $attribute
            ]);
        }

    }

    public function update($product,$attributes){
        ProductAttribute::where('product_id',$product->id)->delete();
        foreach($attributes as $key => $attribute){
            ProductAttribute::create([
                'attribute_id' => $key,
                'product_id' => $product->id,
                'value' => $attribute
            ]);
        }

    }
}
