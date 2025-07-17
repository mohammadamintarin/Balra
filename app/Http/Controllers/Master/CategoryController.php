<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "دسته بندی";
        $categories  = Category::latest()->get();
        $count = count($categories);
        return view('master.category.index' , compact(['title' , 'categories' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "دسته بندی";
        $categories  = Category::where('parent_id' , 0)->get();
        $attributes = Attribute::all();
        return view('master.category.create' , compact(['title' , 'categories' , 'attributes']));
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
                $request->file->move(public_path('/images/category/'), $image);
            }
            $category = Category::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'parent_id' =>$request->parent,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1,
            ]);
            foreach ($request->attribute_ids as $attributeId){
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id , [
                    'filter' => in_array($attributeId , $request->attribute_is_filter_ids) ? 1 : 0 ,
                    'variation' => $request->variation == $attributeId ? 1 : 0,
                ]);
            }
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.category.index')->with('message', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Category $category)
    {
        $title = "ویرایش" . $category->name;
        $categories  = Category::where('parent_id' , 0)->get();
        $attributes = Attribute::all();
        return view('master.category.edit' , compact(['title' , 'category' ,  'categories' , 'attributes']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/category/'), $image);
            }else{
                $image = $category->image;
            }
            $category->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'parent_id' =>$request->parent,
                'image' =>$image,
                'content' => $request->contents,
                'status' => 1,
            ]);
            $category->attributes()->detach();
            foreach ($request->attribute_ids as $attributeId){
                $attribute = Attribute::findOrFail($attributeId);
                $attribute->categories()->attach($category->id , [
                    'filter' => in_array($attributeId , $request->attribute_is_filter_ids) ? 1 : 0 ,
                    'variation' => $request->variation == $attributeId ? 1 : 0,
                ]);
            }
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.category.index')->with('info', 'دسته‌بندی' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('error', 'دسته‌بندی' . ' ' . $category->name . ' ' . 'حذف شد!');
    }
    public function getCategoryAttributes(Category $category)
    {
        $attributes = $category->attributes()->wherePivot('variation' , 0)->get();
        $variation = $category->attributes()->wherePivot('variation' , 1)->first();
        return [
            'attributes' => $attributes,
            'variation' => $variation
        ];

    }
}
