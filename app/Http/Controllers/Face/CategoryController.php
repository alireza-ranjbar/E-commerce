<?php

namespace App\Http\Controllers\Face;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;

class CategoryController extends Controller
{
    public function show(Category $category){

        $filterAttributes = $category->attributes()->where('is_filter',1)->with('attributesValues')->get();
        $variationAttribute = $category->attributes()->where('is_variation',1)->with('variationValues')->first();

        $products = $category->products()->attributeFilter()->variationFilter()->sortFilter()->searchFilter()->paginate(9);

        return view('face.categories.show', compact('category','filterAttributes','variationAttribute','products'));
    }
}
