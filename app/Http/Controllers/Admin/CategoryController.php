<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_categories = Category::where('parent_id',0)->get();
        $attributes = Attribute::all();
        return view('admin.categories.create' , compact('parent_categories','attributes'));
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
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
            'parent_id' => 'required',
            'is_active' => 'required',
            'attribute_ids' => 'required',
            'filter_attribute_ids' => 'required',
            'variation_attribute_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $category = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'icon' => $request->icon
            ]);

            foreach($request->attribute_ids as $attribute_id){
                $category->attributes()->attach($attribute_id,[
                    'is_filter' => in_array($attribute_id , $request->filter_attribute_ids) ? 1 : 0,
                    'is_variation' => $attribute_id == $request->variation_attribute_id ? 1 : 0
                ]);
            }


            DB::commit();

        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ذخیر با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('دسته بندی ذخیره شد','با تشکر');
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parent_categories = Category::where('parent_id',0)->get();
        $attributes = Attribute::all();
        return view('admin.categories.edit', compact('category','parent_categories','attributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id,
            'slug' => 'required|unique:categories,slug,'.$category->id,
            'parent_id' => 'required',
            'is_active' => 'required',
            'attribute_ids' => 'required',
            'filter_attribute_ids' => 'required',
            'variation_attribute_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $category->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'icon' => $request->icon
            ]);


            $category->attributes()->detach();
            foreach($request->attribute_ids as $attribute_id){
                $attribute = Attribute::findOrFail($attribute_id);
                $category->attributes()->attach($attribute->id,[
                    'is_filter' =>in_array($attribute_id , $request->filter_attribute_ids) ? 1 : 0,
                    'is_variation' => $attribute_id == $request->variation_attribute_id ? 1 : 0
                ]);
            }




            DB::commit();

        } catch (\Exception $x) {
            DB::rollBack();
            alert()->warning('ویرایش با خطا روبرو شد','خطا');
            return redirect()->back();
        }

        alert()->success('دسته بندی ویرایش شد','با تشکر');
        return redirect()->route('admin.categories.index');
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

    public function getAttributes(Category $category)
    {
        $filter_attrs = $category->attributes()->wherePivot('is_filter',1)->get();
        $variation_attr = $category->attributes()->wherePivot('is_variation',1)->first();
        return ['filter_attrs' => $filter_attrs , 'variation_attr' => $variation_attr];
    }
}
