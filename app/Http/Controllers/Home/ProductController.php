<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Category $category ,Product $product)
    {
        $products = Product::where('category_id' , $product->category_id)->get();
        $comments = ProductComment::where('product_id' , $product->id)->where('parent_id' , null)->where('status', 1)->latest()->get();
        $title = $product->title;
        $description = $product->description;
        if($product->quantity_check){
            $price = $product->price_check->price;
        }else{
            $price = 0;
        }
        $relateds = Product::where('category_id' , $product->category_id)->take(8)->get();
        $product->increment('viewed');
        return view('home.product.index' ,  compact('products' , 'product' , 'title' , 'description' , 'comments' , 'price' , 'relateds'));
    }
}
