<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title ="کد تخفیف";
        $coupons = Coupon::all();
        return view('master.coupon.index' , compact(['coupons' , 'title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = "افزودن کد تخفیف";
        return view('master.coupon.create'  , compact(['title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            Coupon::create([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'percentage' => $request->percentage,
                'max_percentage_amount' => $request->max_percentage_amount,
                'expired_at' => convertShamsiToGregorianDate($request->expire_at)
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'کد تخفیف' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.coupon.index')->with('message', 'کد تخفیف' . ' ' . $request->name . ' ' . 'ایجاد شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $title = "ویرایش کد تخفیف" . $coupon->name;
        return view('master.coupon.edit' , compact(['title' , 'coupon']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        try {
            DB::beginTransaction();
            $coupon->update([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'percentage' => $request->percentage,
                'max_percentage_amount' => $request->max_percentage_amount,
                'expired_at' => convertShamsiToGregorianDate($request->expire_at)
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'کد تخفیف' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.coupon.index')->with('info', 'کد تخفیف' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('error', 'کد تخفیف' . ' ' . $coupon->name . ' ' . 'حذف شد!');
    }
}
