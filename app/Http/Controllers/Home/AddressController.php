<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function auth;
use function redirect;
use function view;

class AddressController extends Controller
{
    public function index()
    {
        $title = "آدرس‌های من";
        $description = "";
        $addresses = UserAddress::where('user_id', auth()->id())->get();
        $provinces = Province::all();
        return view('home.profile.address' , compact('title' , 'description' , 'addresses' , 'provinces'));
    }

    public function store(Request $request, User $user)
    {
        $userid= User::find(auth()->id());

        $userid->update([
            'name' => $request->name,
            'family' => $request->family,
        ]);
        UserAddress::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'family' => $request->family,
            'mobile' => $request->mobile,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('message', 'آدرس ایجاد شد!');
    }
    public function update(Request $request , UserAddress $address)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'family' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()){
            $validator->errors()->add('address_id' , $address->id);
            return redirect()->back()->withErrors($validator, 'addressUpdate')->withInput();
        }

        $address->update([
            'name' => $request->name,
            'family' => $request->family,
            'mobile' => $request->mobile,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('info', 'آدرس ویرایش شد!');
    }

    public function getProvinceCitiesList(Request $request)
    {
        $cities = City::where('province_id', $request->province_id)->get();
        return $cities;
    }
    public function getUserAddressList(Request $request)
    {
        $addresses = UserAddress::where('user_id', $request->user_id)->get();
        return $addresses;
    }
}
