<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "برند ها";
        $brands = Brand::latest()->get();
        $count = count($brands);
        return view('master.brand.index' , compact(['title' , 'brands' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن برند";
        return view('master.brand.create' , compact( 'title'));
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
                $request->file->move(public_path('/images/brand/'), $image);
            }
            Brand::create([
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
            return back()->with('error', 'برند' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.brand.index')->with('message', 'برند' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Brand $brand)
    {
        $title = "ویرایش"  . $brand->name;
        return view('master.brand.edit' , compact(['brand' , 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Brand $brand)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/brand/'), $image);
            }else{
                $image = $brand->image;
            }
            $brand->update([
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
            return back()->with('error', 'برند' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.brand.index')->with('info', 'برند' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with('error', 'برند' . ' ' . $brand->name . ' ' . 'حذف شد!');
    }
}
