<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate(10);
        return view('admin.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
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
            'image' => 'required|mimes:png,jpg,svg',
            'title' => 'required',
            'text' => 'required',
            'priority' => 'required',
            'type' => 'required',
        ]);

        $imageName = generateFileName($request->image->getClientOriginalName());
        $request->image->move(public_path(env('BANNER_IMAGE_UPLOAD_PATH')),$imageName);

        Banner::create([
            'image' => $imageName,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
        ]);

        alert()->success('بنر با موفقیت ایجاد شد','تشکر');
        return redirect()->route('admin.banners.index');
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
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|mimes:png,jpg,svg',
            'title' => 'required',
            'text' => 'required',
            'priority' => 'required',
            'type' => 'required',
        ]);

        if($request->has('image')){
            $imageName = generateFileName($request->image->getClientOriginalName());
            $request->image->move(public_path(env('BANNER_IMAGE_UPLOAD_PATH')),$imageName);
        }

        $banner->update([
            'image' => $request->has('image') ? $imageName : $banner->image,
            'title' => $request->title,
            'text' => $request->text,
            'priority' => $request->priority,
            'is_active' => $request->is_active,
            'type' => $request->type,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'button_icon' => $request->button_icon,
        ]);

        alert()->success('بنر با موفقیت ویرایش شد','تشکر');
        return redirect()->route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        alert()->success('بنر با موفقیت حذف شد','تشکر');
        return redirect()->route('admin.banners.index');
    }
}
