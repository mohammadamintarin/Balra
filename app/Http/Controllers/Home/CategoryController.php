<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request , Category $category)
    {
        $products = [];
        $outs = [];
        foreach ($category->products()->filter()->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($products, $product);
            }else{
                array_push($outs, $product);
            }
        }
        $count =  count($products) + count($outs);
        $title = $category->title;
        $description = $category->description;
        $category->increment('viewed');
        $attributes = $category->attributes()->where('filter' , 1)->with('values')->get();
        $variation = $category->attributes()->where('variation' , 1)->with('variationValues')->first();
        return view('home.category.index' , compact(['category' ,'products',  'count'  , 'title' , 'description' , 'attributes' , 'variation' , 'outs']));
    }
}
