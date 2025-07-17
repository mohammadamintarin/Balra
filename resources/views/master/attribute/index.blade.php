@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')

    <div class="statistics flex mx-auto justify-between items-center bg-statistics w-[90%] h-25 my-6 p-8 shadow">
        <div class="flex gap-x-2 items-center">
            <span><svg class="w-7 h-7 text-red-700"><use xlink:href="#bell"></use></svg></span>
            <span>تاکنون {{$count ?? ''}} ویژگی در فروشگاه ثبت شده است!</span>
        </div>
        <div><a class="btn btn-success" href="{{route('master.attribute.create')}}">افزودن ویژگی جدید</a></div>
    </div>
    <div class="widget bg-white shadow dark:bg-zinc-500 w-[90%] mx-auto data_more_less dark:bg-zinc-700 dark:text-white">
        <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
            <div class="text-2xl">
                ویژگی‌ها
            </div>
            <div>
                <svg class="w-7 h-7"><use href="#category"></use></svg>
            </div>
        </div>

        <div class="body p-4 py-9 data_more_less_inner" data-height="500" data-increase-by="400">
            <div class="data_more_less_body">
                <table class="w-full mx-auto table-auto text-center border-none">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>تاریخ ایجاد</th>
                        <th>بیشتر</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php($counter = 0)
                    @foreach($attributes as $item)
                        <tr class="item{{$item->id}}">
                            <td>{{++$counter}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{verta($item->created_at)->format('Y.m.d')}}</td>
                            <td class="flex items-center justify-center gap-x-3 text-gray-300">
                                <a class="group relative inline-block px-3" href="{{route('master.attribute.edit' , ['attribute' => $item->id])}}">
                                    <svg class="w-4 h-4"><use href="#edit"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        ویرایش
                                    </div>
                                </a>
                                <a class="group relative inline-block px-3" onClick="deleteItem({{$item->id}} ,'{{$item->name}}' , '{{csrf_token()}}')" href="javascript:void(0)">
                                    <svg class="w-4 h-4"><use href="#delete"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        حذف
                                    </div>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('master.section.paginate')
    </div>
@endsection
@include('master.attribute.delete')
