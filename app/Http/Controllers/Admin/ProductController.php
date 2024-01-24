<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ProductAttributeController;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id','!=',0)->get();
        $brands = Brand::all();
        $tags = Tag::all();
        return view('admin.products.create', compact('categories','brands','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'is_active' => 'required',
            'tags' => 'required',
            'description' => 'required',
            'primary_image' => 'required|mimes:jpg,jpeg,svg,png',
            'other_images' => 'required',
            'other_images.*' => 'mimes:jpg,jpeg,svg,png',
            'category' => 'required',
            'filter_attributes.*' => 'required',
            'variation.*.*' => 'required',
            'variation.price.*' => 'integer',
            'variation.quantity.*' => 'integer',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            //upload and rename image files in a specific controller
            $productImageController = new ProductImageController;
            $imageFilesName = $productImageController->uploadAndRename($request->primary_image ,$request->other_images );

            //store new product
            $product = Product::create([
                'name' => $request->name,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'primary_image' => $imageFilesName['primaryImageName'],
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
            ]);

            //store product other images
            foreach($imageFilesName['otherImagesNames'] as $image){
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image
                ]);
            }

            //store product attributes
            $productAttributeController = new ProductAttributeController;
            $productAttributeController->store($product,$request->filter_attributes);

            //store product variations
            $category = Category::findOrFail($request->category);
            $variation_attribute = $category->attributes()->where('is_variation',1)->first();
            $productVariationController = new ProductVariationController;
            $productVariationController->store($product , $request->variation , $variation_attribute);

            //store product tags
            $product->tags()->attach($request->tags);

            DB::commit();
        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ذخیر با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('ذخیره محصول جدید با موفقیت انجام شد')->persistent('حله');
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product','brands','tags','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'is_active' => 'required',
            'tags' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'filter_attributes.*' => 'required',
            'variation.*.*' => 'required',
            'variation.price.*' => 'integer',
            'variation.quantity.*' => 'integer',
            'delivery_amount' => 'required|integer',
            'delivery_amount_per_product' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            //update product
            $product->update([
                'name' => $request->name,
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'delivery_amount' => $request->delivery_amount,
                'delivery_amount_per_product' => $request->delivery_amount_per_product,
            ]);



            //update product attributes
            $productAttributeController = new ProductAttributeController;
            $productAttributeController->update($product,$request->filter_attributes);

            //update product variations
            $category = Category::findOrFail($request->category);
            $variation_attribute = $category->attributes()->where('is_variation',1)->first();
            $productVariationController = new ProductVariationController;
            $productVariationController->update($request->variation , $product , $variation_attribute);

            //store product tags
            $product->tags()->sync($request->tags);

            DB::commit();

        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ذخیر با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('ویرایش محصول جدید با موفقیت انجام شد')->persistent('حله');
        return redirect()->route('admin.products.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
