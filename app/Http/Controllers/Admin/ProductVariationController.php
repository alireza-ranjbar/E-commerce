<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Http\Request;

class ProductVariationController extends Controller
{
    public function store($product , $variation , $attribute){
        $count = count($variation['name']);
        for($i=0 ; $i < $count ; $i++){
            ProductVariation::create([
                'attribute_id' => $attribute->id,
                'product_id' => $product->id,
                'value' => $variation['name'][$i],
                'price' => $variation['price'][$i],
                'quantity' => $variation['quantity'][$i],
                'sku' => $variation['sku'][$i],
                'sale_price' => $variation['sale_price'][$i],
                'date_on_sale_from' => jalaliToGregorianFrom($variation['date_on_sale_from'][$i]),
                'date_on_sale_to' => jalaliToGregorianTo($variation['date_on_sale_to'][$i]),
            ]);
        }
    }

    public function update($variation , $product , $variation_attribute){
        //delete and then the create

        ProductVariation::where('product_id',$product->id)->delete();
        $count = count($variation['name']);
        for($i=0 ; $i < $count ; $i++){
            ProductVariation::create([
                'attribute_id' => $variation_attribute->id,
                'product_id' => $product->id,
                'value' => $variation['name'][$i],
                'price' => $variation['price'][$i],
                'quantity' => $variation['quantity'][$i],
                'sku' => $variation['sku'][$i],
                'sale_price' => $variation['sale_price'][$i],
                'date_on_sale_from' => jalaliToGregorianFrom($variation['date_on_sale_from'][$i]),
                'date_on_sale_to' => jalaliToGregorianTo($variation['date_on_sale_to'][$i]),
            ]);
        }
    }
}
