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
                    ویرایش {{$slider->name}}
                </div>
                <div>
                    <img class="rounded-full" width="100px" src="{{url('images/slider/thumbnail/' . $slider->image)}}" alt="{{$slider->name}}">
                </div>
            </div>
            <form action="{{route('master.slider.update' , ['slider' =>$slider->id])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            <div class="body p-4 py-9">
                @include('master.section.error')
                <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label>عنوان</label>
                        <div class="mt-2">
                            <input type="text" name="name" value="{{$slider->name}}" required>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <label> لینک</label>
                        <input type="text" name="link" value="{{$slider->link}}" required>
                    </div>
                    <div class="sm:col-span-1">
                        <label> اولویت</label>
                        <input type="text" name="priority" value="{{$slider->priority}}" >
                    </div>
                    <div class="sm:col-span-1">
                        <label>موقعیت </label>
                        <select name="position">
                            <option value="A" {{$slider->type == "A" ? 'selected' : ' '}}>A</option>
                            <option value="B" {{$slider->type == "B" ? 'selected' : ' '}}>B</option>
                            <option value="C" {{$slider->type == "C" ? 'selected' : ' '}}>C</option>
                            <option value="D" {{$slider->type == "D" ? 'selected' : ' '}}>D</option>
                            <option value="E" {{$slider->type == "E" ? 'selected' : ' '}}>E</option>
                            <option value="F" {{$slider->type == "F" ? 'selected' : ' '}}>F</option>
                        </select>
                    </div>
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
