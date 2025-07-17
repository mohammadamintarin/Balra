<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "ویژگی‌ها";
        $attributes = Attribute::all();
        $count = count($attributes);
        return view('master.attribute.index'  , compact(['title' , 'attributes' , 'count']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "ویژگی‌ها";
        return view('master.attribute.create'  , compact(['title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Attribute::create([
            'name' => $request->name
        ]);
        return redirect()->route('master.attribute.index')->with('message', 'ویژگی' . ' ' . $request->name . ' ' . 'ایجاد شد!');
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
    public function edit(Attribute $attribute)
    {
        $title = "ویرایش" . $attribute;
        return view('master.attribute.edit'  , compact(['title' , 'attribute']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $attribute->update([
            'name' => $request->name
        ]);
        return redirect()->route('master.attribute.index')->with('info', 'ویژگی' . ' ' . $request->name . ' ' . 'ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return back()->with('error', 'ویژگی' . ' ' . $attribute->name . ' ' . 'حذف شد!');
    }
}
