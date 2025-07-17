<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs  = Faq::latest()->get();
        $count = count($faqs);
        $title = "سوالات متداول";
        return view('master.faq.index' , compact('faqs' , 'title' , 'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "افزودن سوالات متداول";
        return view('master.faq.create' , compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Faq::create([
           'question' => $request->question,
           'answer' => $request->question,
           'type' => $request->type,
        ]);
        return redirect()->route('master.faq.index')->with('message', 'سوال جدید ایجاد شد!');
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
    public function edit(Faq $faq)
    {
        $title = "ویرایش  سوال";
        return view('master.faq.edit' , compact('title'  , 'faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {

        $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'type' =>$request->type,
            ]);
        return redirect()->route('master.faq.index')->with('info', 'سوال متداول ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('error', 'سوال مورد نظر حذف شد!');
    }
}
