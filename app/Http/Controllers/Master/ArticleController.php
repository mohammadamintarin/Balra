<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "مقالات";
        $articles  = Article::latest()->with('blog')->get();
        $count = count($articles);
        return view('master.article.index' , compact(['title' , 'articles' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن مقاله";
        $blogs =  Blog::getBlogs();
        return view('master.article.create' , compact(['title' , 'blogs']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = " ";
        try {
            DB::beginTransaction();
            if($request->file){
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/article/'), $image);
            }
            Article::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'blog_id' =>$request->blog_id,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1,
                'user_id' => 2,
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'مقاله' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.article.index')->with('message', 'مقاله' . ' ' . $request->name . ' ' . 'ایجاد شد!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $title = "ویرایش" . $article->name;
        $blogs = Blog::getBlogs();
        return view('master.article.edit' , compact(['title'  , 'article' , 'blogs']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/article/'), $image);
            }else{
                $image = $article->image;
            }
            $article->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'blog_id' =>$request->blog_id,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1,
                'user_id' => 2
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'مقاله' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.article.index')->with('info', 'مقاله' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('error', 'مقاله' . ' ' . $article->name . ' ' . 'حذف شد!');
    }
}
