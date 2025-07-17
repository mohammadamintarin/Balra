<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "تماس  با ما";
        $contacts = Contact::all();
        $count =  count($contacts);
        return view('master.contact.index' , compact('contacts' , 'count' ,  'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "تنظیمات تماس  با ما";
        return view('master.contact.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $image = " ";
        if($request->file){
            $image = generateFileName($request->file->getClientOriginalName());
            $request->file->move(public_path('/images/contact/'), $image);
        }
        Contact::create([
            "title" => $request->title,
            "description" => $request->description,
            "phone" => $request->phone,
            "mobile" => $request->mobile,
            "about" => $request->about,
            "address" => $request->address,
            "logo" => $image,
            "email" => $request->email,
            "about" => $request->about,
            "coordinates" => $request->coordinates,
            "telegram" => $request->telegram,
            "instagram" => $request->instagram,
            "whatsapp" => $request->whatsapp,
            "bale" => $request->bale,
            "eita" => $request->eita,
        ]);
        return redirect(route('master.contact.index'));
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
    public function edit(Contact $contact)
    {
        $title = "ویرایش  تماس  با ما";
        return view('master.contact.edit' , compact('contact' ,'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        if($request->file)
        {
            $image = generateFileName($request->file->getClientOriginalName());
            $request->file->move(public_path('/images/category/'), $image);
        }else{
            $image = $contact->image;
        }
        $contact->update([
            "title" => $request->title,
            "description" => $request->description,
            "phone" => $request->phone,
            "mobile" => $request->mobile,
            "about" => $request->about,
            "address" => $request->address,
            "logo" => $image,
            "email" => $request->email,
            "about" => $request->about,
            "coordinates" => $request->coordinates,
            "telegram" => $request->telegram,
            "instagram" => $request->instagram,
            "whatsapp" => $request->whatsapp,
            "bale" => $request->bale,
            "eita" => $request->eita,
        ]);
        return redirect(route('master.contact.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
