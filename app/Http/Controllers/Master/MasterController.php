<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {

    }
    public function contentUploadImage()
    {
        $this->validate(request() , [
            'upload' => 'required|mimes:jpeg,png,webp,svg,bmp,jpg,Webp,JPEG',
        ]);
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $imagePath = "/images/content/{$year}/{$month}/";
        $image = request()->file('upload');
        $imageName = Carbon::now()->timestamp . '-' . $image->getClientOriginalName();
        $image->move(public_path($imagePath) , $imageName);
        $url = $imagePath . $imageName;
        return "<script>window.parent.CKEDITOR.tools.callFunction(1 , '{$url}')</script>";
    }
}
