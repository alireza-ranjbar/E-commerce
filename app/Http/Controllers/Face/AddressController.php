<?php

namespace App\Http\Controllers\Face;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = UserAddress::where('user_id',auth()->id())->get();
        $provinces = Province::all();
        return view('face.profile.address',compact('provinces','addresses'));
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

        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'cellphone' => 'required|iran_mobile',
            'address' => 'required',
            'postal_code' => 'required|iran_postal_code',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->to(url()->previous().'#store-form')->withErrors($validator,'storing');
        }

        UserAddress::create([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'user_id' => auth()->id(),
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
        ]);

        alert()->success('The address was stored.','Well Done!');
        return redirect()->back();

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $address)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'cellphone' => 'required|iran_mobile',
            'address' => 'required',
            'postal_code' => 'required|iran_postal_code',
            'province_id' => 'required',
            'city_id' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->to(url()->previous().'#edit-form-'.$address->id)->withErrors($validator,'updating-'.$address->id);
        }

        $address->update([
            'title' => $request->title,
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
        ]);

        alert()->success('The address was edited.','Well Done!');
        return redirect()->back();
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

    public function getProvinceCitiesList(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->get();
        return $cities;
    }
}
