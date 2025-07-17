<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return view('home.profile.index');
    }

    public function update(Request $request , User $user)
    {
        $user = User::find($user);
        $name = $request->name != null ? $request->name : $user[0]->name;
        $family =$request->family != null ? $request->family : $user[0]->family;
        $avatar = " ";
        try {
            DB::beginTransaction();
            if($request->avatar){
                $avatar = '/images/avatar/' . generateFileName($request->avatar->getClientOriginalName());
                $request->avatar->move(public_path('/images/avatar/'), $avatar);
            }
           $user[0]->update([
                'name' => $name,
                'family' => $family,
                'avatar' => $avatar,
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'حساب کاربری ویرایش نشد!');
        }
        return redirect()->route('profile.index')->with('message', 'حساب کاربری ویرایش شد!');
    }

    public function orders()
    {
        dd("sdf");
        $orders = Order::where('user_id' , auth()->user()->id)->where('payment_status' , 1)->latest()->get();
        $title = "سفارش‌های من";
        $description =  "لیست سفارش‌های من";
        return view('home.profile.order' , compact('orders' , 'title' , 'description'));
    }
}
