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
                        ویرایش {{$brand->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#category"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.brand.update' , ['brand' => $brand->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>نام برند</label>
                                <input type="text" name="name" value="{{$brand->name}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان انگلیسی</label>
                                <input type="text" name="en" value="{{$brand->en}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>وضعیت</label>
                                <select name="status">
                                    <option value="1" {{$brand->status == 1 ? "selected" : " "}}>فعال</option>
                                    <option value="0" {{$brand->status == 0 ? "selected" : " "}}>غیرفعال</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان سئو</label>
                                <input type="text" name="title" value="{{$brand->title}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>توضیحات سئو</label>
                                <input type="text" name="description" value="{{$brand->description}}">
                            </div>
                            <div class="sm:col-span-2">
                                <label>لینک کنونیکال</label>
                                <input type="text" name="canonical" value="{{$brand->canonical}}">
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block">محتوا</label>
                            <textarea id="editor" name="contents">{!! $brand->content !!}</textarea>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                            <div class="upload">
                                <label for="myfile">Select a file:</label>
                                <input type="file" id="myfile" name="file">
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @include('master.section.editor')
@endsection
