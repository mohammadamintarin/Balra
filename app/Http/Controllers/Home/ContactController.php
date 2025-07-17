<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $title = "تماس با ما";
        $description = "";
        return view('home.contact.index' , compact('title' , 'description'));
    }
}
