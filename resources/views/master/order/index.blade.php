@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')

    <div class="statistics flex mx-auto justify-between items-center bg-statistics w-[90%] h-25 my-6 p-8 shadow">
        <div class="flex gap-x-2 items-center">
            <span><svg class="w-7 h-7 text-red-700"><use xlink:href="#bell"></use></svg></span>
            <span>تاکنون {{$count ?? ''}} سفارش در فروشگاه ثبت شده است!</span>
        </div>
        <div><a class="btn btn-success" href="{{route('master.order.create')}}">افزودن سفارش جدید</a></div>
    </div>


    <div class="widget bg-white shadow dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
        <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
            <div class="text-2xl">
                سفارش‌ها
            </div>
            <div>
                <svg class="w-7 h-7"><use href="#article"></use></svg>
            </div>
        </div>
        <div class="body p-4 py-9 data_more_less_inner" data-height="15500" data-increase-by="15400">
            <div class="data_more_less_body">
                <table class="w-full mx-auto table-auto text-center border-none">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>مبلغ</th>
                        <th>تاریخ </th>
                        <th>تراکنش</th>
                        <th>رهگیری</th>
                        <th>بیشتر</th>
                    </tr>
                    </thead>
                    <tbody id="myTable">
                    @php($counter = 0)
                    @foreach($orders as $order)
                        <tr>
                            <!--<td>{{++$counter}}</td>-->
                            <td>{{$order->id}}</td>
                            <td>{{$order->user->name}} {{$order->user->family}}</td>
                            <td> {{number_format($order->paying_amount)}}</td>
                            <td>{{verta($order->created_at)->format("d M y")}}</td>
                            <td>{{$order->ref_id}}</td>
                            <td>
                                <a class="group relative inline-block px-1" href="">
                                        <img class="w-4 h-4" src="/admin/image/instagram.svg" alt="cash">
                                        <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                            <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                            اینستاگرام
                                        </div>
                                </a>
                            </td>
                            <td class="flex items-center justify-center gap-x-3 text-gray-300">
                                <a class="group relative inline-block px-1" href="{{ route('master.order.show' , ['order' => $order->id ])}}" target="_blank">
                                    <svg class="w-4 h-4"><use href="#products"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        مشاهده
                                    </div>
                                </a>
                                <a class="group relative inline-block px-1" href="">
                                    @if($order->payment == 'snapppay')
                                        <svg class="w-4 h-4"><use href="#snapp"></use></svg>
                                        <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                            <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                            اسنپ‌پی
                                        </div>
                                    @elseif($order->payment == 'online')
                                        <img class="w-4 h-4" src="/admin/image/zarinpal.svg" alt="zarinpal">
                                        <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                            <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                            آنلاین
                                        </div>

                                    @elseif($order->payment == 'cash')
                                        <img class="w-6 h-6" src="/admin/image/cash.svg" alt="cash">
                                        <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                            <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                            نقدی
                                        </div>
                                    @endif
                                </a>
{{--                                <a class="group relative inline-block px-1" href="{{route('master.order.change.type' , ['order' => $order->id ])}}">--}}
                                @switch($order->status)
                                    @case('registered')
                                    <svg class="w-4 h-4"><use href="#registered"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        ثبت‌شده
                                    </div>
                                    @break
                                    @case('sending')
                                    <svg class="w-4 h-4"><use href="#sending"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        ارسال
                                    </div>
                                    @break
                                    @case('returned')
                                    <svg class="w-4 h-4"><use href="#returned"></use></svg>
                                    <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                        <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                        مرجوع
                                    </div>
                                    @break
                                    @case('delivered')
                                    @break
                                @endswitch
                                </a>
                                @if($order->calltosendcomment == 0)
                                    <form action="{{ route('master.order.call.to.send.comment' , ['order' => $order->id ])}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="group relative inline-block px-1">
                                            <svg class="w-4 h-4"><use href="#comments"></use></svg>
                                            <div class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                                <span class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                                دیدگاه
                                            </div>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('master.section.paginate')
    </div>
    <div class="w-[90%]  mx-auto text-left">
        <a class="text-xs text-gray-500" href="/master/failed-order">سفارشات ناموفق</a>
    </div>
@endsection
@include('master.article.delete')
