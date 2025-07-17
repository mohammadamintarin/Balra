<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $title = "سوالات متداول";
        $sends = Faq::where('type' , 'send')->get();
        $abouts = Faq::where('type' , 'about')->get();
        $terms = Faq::where('type' , 'rule')->get();
        $returns = Faq::where('type' , 'politic')->get();
        return view('home.faq.index' , compact('returns' ,'sends', 'abouts' , 'title'  , 'terms'));
    }
}
