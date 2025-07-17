<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show(Brand $brand)
    {
        $products = [];
        $outs = [];
        foreach (Product::where('brand_id'  , $brand->id)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($products, $product);
            }else{
                array_push($outs, $product);
            }
        }
        $count =  count($products) + count($outs);
        $title = $brand->title;
        $description = $brand->description;
        $brand->increment('viewed');
        return view('home.brand.index' , compact(['brand' ,  'products' , 'outs' , 'count' , 'title' , 'description']));
    }

    public function brands()
    {
        $brands = Brand::all();
        return view('home.brand.brands' , compact('brands'));
    }
}
