<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function add(Product $product)
    {
        if(auth()->check())
        {
            if (!$product->checkUserWishlist(auth()->id()))
            {
                WishList::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id
                ]);
            }
            return back();
        }else{
            return view('auth.auth');
        }
    }

    public function remove(Product $product)
    {
        if(auth()->check())
        {
            $withlist = Wishlist::where('product_id' , $product->id)->where('user_id' , auth()->id())->firstOrFail();
            if($withlist)
            {
                Wishlist::where('product_id' , $product->id)->where('user_id' , auth()->id())->delete();
            }
            return back();
        }else{
            return view('auth.auth');
        }
    }
    public function wishlist()
    {
        $wishlists = Wishlist::where('user_id' , auth()->id())->get();
        $title = "لیست علاقه‌مندی";
        $description = "";
        return view('home.profile.wishlist' , compact('wishlists' , 'title' , 'description'));
    }
}
