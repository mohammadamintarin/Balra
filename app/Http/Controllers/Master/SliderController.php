<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title ="اسلایدرها";
        $sliders = Slider::orderBy('priority' , 'desc')->get();
        return view('master.slider.index' , compact(['sliders' , 'title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title  = "افزودن اسلایدر";
        return view('master.slider.create'  , compact(['title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $image = generateFileName($request->file->getClientOriginalName());
            $request->file->move(public_path('/images/slider/'), $image);
            Slider::create([
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
            return back()->with('error', 'اسلایدر' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.slider.index')->with('message', 'اسلایدر' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Slider $slider)
    {
        $title = "ویرایش اسلایدر" . $slider->name;
        return view('master.slider.edit' , compact(['title' , 'slider']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        try {
            DB::beginTransaction();
            if($request->file)
            {
                $image = generateFileName($request->file->getClientOriginalName());
                $request->file->move(public_path('/images/slider/'), $image);
            }else{
                $image = $slider->image;
            }
            $slider->update([
                'name' => $request->name,
                'priority' => $request->priority,
                'link' =>$request->link,
                'position' =>$request->position,
                'image' =>$image,
            ]);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollBack();
            return back()->with('error', 'اسلایدر' . ' ' . $request->name . ' ' . 'ایجاد نشد!');
        }
        return redirect()->route('master.slider.index')->with('info', 'اسلایدر' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return back()->with('error', 'اسلایدر' . ' ' . $slider->name . ' ' . 'حذف شد!');
    }
}
