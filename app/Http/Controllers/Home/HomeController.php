<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\Counter;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $offers = [];
        foreach (Product::where('offer' ,  1)->get() as $offer)
        {
            if($offer->sale_check)
            {
                array_push($offers, $offer);
            }
        }
        $articles = Article::take(8)->get();
        $sliders =  Slider::latest()->orderBy('priority' , 'desc')->get();
        $banners = Banner::where('position' , 'A')->orderBy('priority' , 'desc')->get();


        $products = [];
        foreach (Product::where('category_id' , 3)->take(12)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($products, $product);
            }
        }
        $mens = [];
        foreach (Product::where('category_id' , 2)->take(12)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($mens, $product);
            }
        }

        $bests = [];
        foreach (Product::where('best' , 1)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($bests, $product);
            }
        }
        $wrestlings = [];
        foreach (Product::where('category_id' , 8)->take(8)->get() as $product)
        {
            if($product->quantity_check)
            {
                array_push($wrestlings, $product);
            }
        }
        $count = Counter::find(1);
        $count->increment('viewed');
        return view('index' ,compact(['articles' , 'sliders' , 'banners'  ,'offers' , 'bests' , 'wrestlings']));
    }
    public function search(Request $request){
        $search = $request->input('search');
        $results = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('en', 'LIKE', "%{$search}%")
            ->get();
        $title = "نتایج جستجو";
        $description = "نتایج جستجو در محصولات فروشگاه کتونی سمور";
        $count = count($results);
        return view('home.search.index', compact('results' , 'title' , 'description' , 'count'));
    }
}
