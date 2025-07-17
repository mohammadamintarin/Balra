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
                    پیکربندی
                </div>
                <div>
                    <svg class="w-7 h-7"><use href="#article"></use></svg>
                </div>
            </div>
            <form action="{{route('master.contact.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="body p-4 py-9">
                @include('master.section.error')
                <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label>عنوان سایت</label>
                            <input type="text" name="title" value="{{old('title')}}" >
                    </div>
                    <div class="sm:col-span-2">
                        <label> توضیحات  مختصر سایت</label>
                        <input type="text" name="description" value="{{old('description')}}" >
                    </div>
                    <div class="sm:col-span-2">
                        <label>شماره  موبایل</label>
                        <input type="text" name="mobile" value="{{old('mobile')}}" >
                    </div>
                    <div class="sm:col-span-2">
                        <label>پست الکترونیک</label>
                        <input type="text" name="email" value="{{old('email')}}" >
                    </div>
                    <div class="sm:col-span-2">
                        <label> لوکیشن</label>
                        <input type="text" name="coordinates" value="{{old('coordinates')}}">
                    </div>
                    <div class="sm:col-span-2">
                        <label> آدرس</label>
                        <input type="text" name="address" value="{{old('address')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>شماره ثابت</label>
                        <input type="text" name="phone" value="{{old('phone')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>اینستاگرام</label>
                        <input type="text" name="instagram" value="{{old('instagram')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>تلگرام</label>
                        <input type="text" name="telegram" value="{{old('telegram')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>واتس اپ</label>
                        <input type="text" name="whatsapp" value="{{old('whatsapp')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>بله</label>
                        <input type="text" name="bale" value="{{old('bale')}}">
                    </div>
                    <div class="sm:col-span-1">
                        <label>ایتا</label>
                        <input type="text" name="eita" value="{{old('eita')}}">
                    </div>
                </div>
                <div class="w-full">
                    <label>درباره ما</label>
                    <textarea  name="about" rows="4" cols="50" style="height: 200px"></textarea>
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
