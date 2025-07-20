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
        $articles = Article::take(8)->get();
        $sliders = Slider::where('position', 'A')->orderBy('priority', 'desc')->get();
        $categorySlider = Slider::where('position', 'B')->orderby('priority', 'desc')->get();
        $bannerOne = Banner::where('position', 'A')->get();
        $bannerTwo = Banner::where('position', 'B')->orderBy('priority', 'desc')->get();
        $offers = Product::where('offer', 1)->take(8)->get();
        $bests = Product::where('best', 1)->take(8)->get();
        $latests = Product::latest()->take(8)->get();

        $products = [];
        foreach (Product::where('category_id', 3)->take(12)->get() as $product) {
            if ($product->quantity_check) {
                array_push($products, $product);
            }
        }
        $count = Counter::find(1);
        $count->increment('viewed');
        return view('index', compact(['articles', 'sliders', 'bannerOne', 'bannerTwo', 'categorySlider', 'offers', 'bests' , 'latests']));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $results = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('en', 'LIKE', "%{$search}%")
            ->get();
        $title = "نتایج جستجو";
        $description = "نتایج جستجو در محصولات فروشگاه کتونی سمور";
        $count = count($results);
        return view('home.search.index', compact('results', 'title', 'description', 'count'));
    }
}
