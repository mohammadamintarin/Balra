<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function index()
    {
        return view('home.sitemap.index');
    }

    public function categories()
    {
        $categories = Category::where('parent_id' , '!=' ,  0)->get();
        return view('home.sitemap.category' , compact('categories'));
    }

    public function brands()
    {
        $brands = Brand::all();
        return view('home.sitemap.brand' , compact('brands'));
    }
    public function models()
    {
        $models = Type::all();
        return view('home.sitemap.model' , compact('models'));
    }
    public function tags()
    {
        $tags = Tag::all();
        return view('home.sitemap.tag' , compact('tags'));
    }
    public function products()
    {
        $products = Product::all();
        return view('home.sitemap.product' , compact('products'));
    }

    public function blogs()
    {
        $blogs = Blog::all();
        return view('home.sitemap.blog' , compact('blogs'));
    }
    public function articles()
    {
        $articles = Article::all();
        return view('home.sitemap.article' ,  compact('articles'));
    }

}
