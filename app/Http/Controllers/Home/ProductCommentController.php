<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductRate;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCommentController extends Controller
{
    public function store(Request $request , Product $product)
    {
        $request->validate([
            'contents' => 'required|min:5|max:7000',
            'rate' => 'required|digits_between:0,5'
        ]);
        try {
            DB::beginTransaction();
            if ($request->name != null && $request->family != null) {
                $user = \App\Models\User::findOrFail($request->user_id);
                $user->update([
                    'name' => $request->name,
                    'family' => $request->family
                ]);
            }
            ProductComment::create([
                'user_id' => $request->user_id,
                'product_id' => $product->id,
                'content' => $request->contents,
            ]);
            if ($product->rates()->where('user_id', auth()->id())->exists()) {
                $productRate = $product->rates()->where('user_id', auth()->id())->first();
                $productRate->update([
                    'rate' => $request->rate
                ]);
            } else {
                ProductRate::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'rate' => $request->rate
                ]);
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'ثبت دیدگاه ناموفق بود!');
        }
        return redirect()->back()->with('message', 'دیدگاه شما پس از تایید منتشر خواهد شد!');
    }
}
