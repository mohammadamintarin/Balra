<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show(Article  $article)
    {
        $title = $article->title;
        $description = $article->description;
        $article->increment('viewed');
        return view('home.article.index' ,  compact('article' , 'title' , 'description'));
    }
}
