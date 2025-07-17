<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function show(Type $type)
    {
        $products = [];
        $outs = [];
        foreach (Product::where('type_id'  , $type->id)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($products, $product);
            }else{
                array_push($outs, $product);
            }
        }
        $count =  count($products) + count($outs);
        $title = $type->title;
        $description = $type->description;
        $type->increment('viewed');
        return view('home.type.index' , compact(['type' ,'products', 'outs' ,  'count' , 'title' , 'description']));
    }
}
