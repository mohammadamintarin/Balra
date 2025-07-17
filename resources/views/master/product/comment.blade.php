@extends('layout.master')
@section('title')
    {{$title}}
@endsection

@section('content')

    <div class="statistics flex mx-auto justify-between items-center bg-statistics h-25 my-6 p-8 shadow">
        <div class="flex gap-x-2 items-center">
            <span><svg class="w-7 h-7 text-red-700"><use xlink:href="#bell"></use></svg></span>
            <span>تاکنون {{$count ?? ''}} دیدگاه در فروشگاه ثبت شده است!</span>
        </div>
    </div>


    <div class="widget bg-white shadow dark:bg-zinc-500 mx-auto data_more_less">
        <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
            <div class="text-2xl">
                دیدگاه‌ها
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
                        <th>محصول</th>
                        <th>دیدگاه</th>
                        <th>کاربر</th>
                        <th>بیشتر</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php($counter = 1)
                    @foreach($comments as $item)
                        <tr class="item{{$item->id}}">
                            <td>{{$counter++}}</td>
                            <td><img src="{{ url('images/product') . '/' . $item->product->image}}" alt="{{$item->product->name}}" width="50px" height="50px"></td>
                            <td><a href="/product/{{$item->product->slug}}" target="_blank">{!! \Illuminate\Support\Str::limit($item->content , 22) !!}</a></td>
                            <td>{{$item->user->name}} {{$item->user->family}}</td>
                            <td class="flex items-center justify-center gap-x-1 text-gray-300">
                                @if($item->status == 0)
                                    <a class="group relative inline-block px-1" href="{{route('master.product.comment.change.status' , ['productComment' => $item->id])}}">
                                        <svg class="w-4 h-4"><use href="#fail"></use></svg>
                                        <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                            <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>

                                            تایید
                                        </div>
                                    </a>
                                @endif
                                <a class="group relative inline-block px-1" href="{{route('master.product.comment.detail' , ['productComment' => $item->id])}}">
                                    <svg class="w-4 h-4"><use href="#edit"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        پاسخ
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
@include('master.product.delete')
