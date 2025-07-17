<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show(Blog $blog)
    {
        $articles = Article::where('blog_id'  , $blog->id)->get();
        $latests = Article::latest()->take(4)->get();
        $title = $blog->title;
        $description = $blog->description;
        $blog->increment('viewed');
        return view('home.blog.index' , compact(['blog' ,'articles' , 'latests' , 'title' , 'description']));
    }
}
