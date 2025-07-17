<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "مدل ها";
        $types = Type::latest()->get();
        $count = count($types);
        return view('master.type.index' , compact(['title' , 'types' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن مدل";
        $brands = Brand::all();
        return view('master.type.create' , compact('brands' , 'title'));
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
                $request->file->move(public_path('/images/model/'), $image);
            }
            Type::create([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'image' =>$image,
                'content' => $request->contents,
                'brand_id' => $request->brand_id,
                'status' => 1
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'مدل' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.type.index')->with('message', 'مدل' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Type $type)
    {
        $title = "ویرایش"  . $type->name;
        $brands = Brand::all();
        return view('master.type.edit' , compact(['brands' ,  'type' , 'title']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Type $type)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/model/'), $image);
            }else{
                $image = $type->image;
            }
            $type->update([
                'name' => $request->name,
                'en' => $request->en,
                'slug' =>str()->slug($request->en),
                'title' =>$request->title,
                'description' =>$request->description,
                'canonical' =>$request->canonical,
                'image' =>$image,
                'content' => $request->contents,
                'brand_id' => $request->brand_id,
                'status' => 1
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'مدل' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.type.index')->with('info', 'مدل' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return back()->with('error', 'مدل' . ' ' . $type->name . ' ' . 'حذف شد!');
    }
}
