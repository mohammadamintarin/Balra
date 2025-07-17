@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                        پاسخ به دیدگاه
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#article"></use></svg>
                    </div>
                </div>
                <div class="body p-4 py-9">
                    <label> دیدگاه</label>
                    <p >{!! $productComment->content !!}</p>
                    <br>
                </div>
                @if(count($replies) == 0)
                    <form action="{{route('master.product.comment.reply')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{$productComment->id}}">
                        <input type="hidden" name="product_id" value="{{$productComment->product_id}}">
                        <div class="body p-4 py-9">
                            @include('master.section.error')
                            <div class="w-full">
                                <label class="block">پاسخ</label>
                                <textarea id="editor" name="contents">{{old('content')}}</textarea>
                            </div>
                        </div>
                        <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                            <div></div>
                            <div>
                                <button class="btn btn-success" type="submit">ذخیره</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="body p-4 py-9">
                        <label> پاسخ</label>
                        <p >{!! $replies[0]->content !!}</p>
                        <br><br>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('script')
    @include('master.section.editor')
@endsection
