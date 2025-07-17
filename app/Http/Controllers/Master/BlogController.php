<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "دسته‌بندی";
        $blogs = Blog::latest()->get();
        $count = count($blogs);
        return view('master.blog.index' , compact(['title' , 'blogs' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن دسته‌بندی";
        $blogs = Blog::getBlogs();
        return view('master.blog.create' , compact('blogs' , 'title'));
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
                $request->file->move(public_path('/images/blog/'), $image);
            }
            Blog::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'parent' =>$request->parent_id,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.blog.index')->with('message', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Blog $blog)
    {
        $title = "ویرایش"  . $blog->name;
        $blogs = Blog::getBlogs();
        return view('master.blog.edit' , compact(['blogs' ,  'blog' , 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Blog $blog)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/blog/'), $image);
            }else{
                $image = $blog->image;
            }
            $blog->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'parent' =>$request->parent_id,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.blog.index')->with('info', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back()->with('error', 'دسته‌بندی' . ' ' . $blog->name . ' ' . 'حذف شد!');
    }
}
