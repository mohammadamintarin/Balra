@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="statistics shadow-lg flex mx-auto justify-between items-center bg-statistics w-[90%] h-25 my-6 p-8 border border-gray-100">
                <div class="flex gap-x-2 items-center">
                    <span><svg class="w-7 h-7 text-red-700"><use xlink:href="#bell"></use></svg></span>
{{--                    <span class="text-lg"> تاکنون {{$users->count()}} کاربر در فروشگاه ثبت شده است!</span>--}}
                </div>
                <div class="flex gap-x-1">
                    @if($count == 0)
                        <a href="/master/contact/create" class="text-white bg-teal-500 px-4 py-2 rounded-sm border-2 transition-all border-teal-500 hover:bg-transparent hover:text-teal-500">
                            پیکربندی  سایت
                        </a>
                    @endif
                </div>
            </div>
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                        پیکربندی
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#article"></use></svg>
                    </div>
                </div>
                <div class="body p-4 py-9 data_more_less_inner" data-height="500" data-increase-by="400">
                    <div class="data_more_less_body">
                        <table class="w-full mx-auto table-auto text-center border-none">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان سایت</th>
                                <th>شماره موبایل</th>
                                <th>پست الکترونیک</th>
                                <th>ویرایش</th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @php($counter = 0)
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{++$counter}}</td>
                                    <td>{{$contact->title}}</td>
                                    <td>{{$contact->mobile}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>
                                        <a class="group relative inline-block px-3" href="{{route('master.contact.edit' , ['contact' => $contact->id])}}">
                                            <svg class="w-4 h-4"><use href="#edit"></use></svg>
                                            <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                                <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                                ویرایش
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
