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
                        ویرایش {{$type->name}}
                    </div>
                    <div>
                        <img src="{{ url('images/model/image') . '/' . $type->image}}" class="img-fluid" alt="{{$type->name}}" width="100px">
                    </div>
                </div>
                <form action="{{route('master.type.update' , ['type' => $type->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>نام دسته‌بندی</label>
                                <input type="text" name="name" value="{{$type->name}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان انگلیسی</label>
                                <input type="text" name="en" value="{{$type->en}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>برند</label>
                                <select name="brand_id">
                                    <option value="0" selected>-</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" {{$type->brand_id == $brand->id ? "selected" :  " "}}>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان سئو</label>
                                <input type="text" name="title" value="{{$type->title}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>توضیحات سئو</label>
                                <input type="text" name="description" value="{{$type->description}}">
                            </div>
                            <div class="sm:col-span-2">
                                <label>لینک کنونیکال</label>
                                <input type="text" name="canonical" value="{{$type->canonical}}">
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block">محتوا</label>
                            <textarea id="editor" name="contents">{!! $type->content !!}</textarea>
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
