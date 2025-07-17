<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    public function index()
    {
        $comments = ProductComment::where('parent_id' , null)->latest()->get();
        $count = count(ProductComment::all());
        $title = 'دیدگاه ها';
        return view('master.product.comment' , compact(['comments' , 'count' , 'title']));
    }

    public function detail(ProductComment $productComment)
    {
        $title = 'دیدگاه ها';
        $replies = ProductComment::where('parent_id' , $productComment->id)->get();
        return view('master.product.reply' , compact(['productComment' , 'replies' , 'title']));
    }
    public function reply(Request $request)
    {
        ProductComment::create([
            'parent_id' => $request->parent_id,
            'product_id' => $request->product_id,
            'user_id' => 2,
            'content' => $request->contents,
            'status' => 1
        ]);
        return redirect()->route('master.product.comment')->with('message', 'پاسخ دیدگاه ذخیره شد!');
    }

    public function changeStatus(ProductComment $productComment)
    {
        if ($productComment->status == 0)
        {
            $productComment->update(['status' => 1]);
            return redirect()->back()->with('message', 'دیدگاه تایید شد!');
        }
        else
        {
            $productComment->update(['status' => 0]);
            return redirect()->back()->with('error', 'دیدگاه تایید نشد!');
        }
    }
}
