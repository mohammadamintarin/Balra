<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(Request $request , Tag $tag)
    {
        $products = [];
        $outs = [];
        foreach ($tag->products()->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($products, $product);
            }else{
                array_push($outs, $product);
            }
        }
        $count =  count($products) + count($outs);
        $title = $tag->title;
        $description = $tag->description;
        $tag->increment('viewed');
        return view('home.tag.index' , compact(['tag' ,'products', 'outs' ,  'count' , 'title' , 'description']));
    }
}
