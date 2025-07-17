<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title ="بنرها";
        $banners = Banner::orderBy('priority' , 'desc')->get();
        return view('master.banner.index' , compact(['banners' , 'title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = "افزودن بنر";
        return view('master.banner.create'  , compact(['title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $image = generateFileName($request->file->getClientOriginalName());
            $request->file->move(public_path('/images/banner/'), $image);
            Banner::create([
                'name' => $request->name,
                'priority' => $request->priority,
                'link' =>$request->link,
                'position' =>$request->position,
                'image' =>$image,
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            return back()->with('error', 'بنر' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.banner.index')->with('message', 'بنر' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Banner $banner)
    {
        $title = "ویرایش بنر" . $banner->name;
        return view('master.banner.edit' , compact(['title' , 'banner']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/banner/'), $image);
            }else{
                $image = $banner->image;
            }
            $banner->update([
                'name' => $request->name,
                'priority' => $request->priority,
                'link' =>$request->link,
                'position' =>$request->position,
                'image' =>$image,
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'بنر' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.banner.index')->with('info', 'بنر' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back()->with('error', 'بنر' . ' ' . $banner->name . ' ' . 'حذف شد!');
    }
}
