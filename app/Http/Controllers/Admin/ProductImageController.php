<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use function PHPSTORM_META\type;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit_images', compact('product'));
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
            'primary_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'other_images.*' => 'nullable|mimes:jpg,jpeg,png,svg',
        ]);

        if ($request->primary_image == null && $request->other_images == null) {
            return redirect()->back()->withErrors(['msg' => 'هیچ تصویر جدیدی برای ثبت ارسال نشده است.']);
        }

        //upload a new image and substitude it with the primary image
        //Also, previous primary shall be set as an oridinary image.
        $previousPrimaryImageName = $product->primary_image;
        if ($request->has('primary_image')) {
            $primaryImageName = generateFileName($request->primary_image->getClientOriginalName());
            $request->primary_image->move(public_path(env('PRODUCT_IMAGE_UPLOAD_PATH')), $primaryImageName);
            $product->update([
                'primary_image' => $primaryImageName
            ]);
            ProductImage::create([
                'image' => $previousPrimaryImageName,
                'product_id' => $product->id
            ]);
        }

        if ($request->has('other_images')) {
            $otherImagesNames = [];
            foreach ($request->other_images as $image) {
                $imageName = generateFileName($image->getClientOriginalName());
                $image->move(public_path(env('PRODUCT_IMAGE_UPLOAD_PATH')), $imageName);
                array_push($otherImagesNames, $imageName);
            }

            foreach ($otherImagesNames as $imageName) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imageName
                ]);
            }
        }

        alert()->success('تغییرات با موفقیت اعمال شد', 'با تشکر');
        return redirect()->back();
    }


    public function setPrimary(Product $product, Request $request)
    {
        $request->validate([
            'image_id' => 'exists:product_images,id'
        ]);
        $nonPrimaryImageName = ProductImage::where('id', $request->image_id)->first()->image;
        $primaryImageName = $product->primary_image;

        $product->update([
            'primary_image' => $nonPrimaryImageName,
        ]);

        ProductImage::where('id', $request->image_id)->first()->update([
            'image' => $primaryImageName,
        ]);

        alert()->success('تصویر اصلی با موفقیت تغییر کرد', 'با تشکر');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        $request->validate([
            'image_id' => 'exists:product_images,id'
        ]);
        ProductImage::where('id', $request->image_id)->first()->delete();
        alert()->success('تصویر با موفقیت حذف شد', 'با تشکر');
        return redirect()->back();
    }

    //upload and rename image files
    public function uploadAndRename($primaryImage, $otherImages)
    {
        $primaryImageName = generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path(env('PRODUCT_IMAGE_UPLOAD_PATH')), $primaryImageName);

        $otherImagesNames = [];
        foreach ($otherImages as $image) {
            $imageName = generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('PRODUCT_IMAGE_UPLOAD_PATH')), $imageName);
            array_push($otherImagesNames, $imageName);
        }

        return ['primaryImageName' => $primaryImageName, 'otherImagesNames' => $otherImagesNames];
    }
}
