<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "تگ ها";
        $tags = Tag::latest()->get();
        $count = count($tags);
        return view('master.tag.index' , compact(['title' , 'tags' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن تگ";
        return view('master.tag.create' , compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = "";
        try {
            DB::beginTransaction();
            if($request->file){
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/tag/'), $image);
            }
            Tag::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'image' =>$image,
                'content' => $request->contents,
                'status' => $request->status
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'تگ' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.tag.index')->with('message', 'تگ' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Tag $tag)
    {
        $title = "ویرایش"  . $tag->name;
        return view('master.tag.edit' , compact(['tag' , 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Tag $tag)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/tag/'), $image);
            }else{
                $image = $tag->image;
            }
            $tag->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'image' =>$image,
                'content' => $request->contents,
                'status' => $request->status
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'تگ' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.tag.index')->with('info', 'تگ' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('error', 'تگ' . ' ' . $tag->name . ' ' . 'حذف شد!');
    }
}
