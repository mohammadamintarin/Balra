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
 سفارشات
{{--                        {{$user->name}} {{$user->family}}--}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#products"></use></svg>
                    </div>
                </div>
                <div class="widget bg-white dark:bg-zinc-500  mx-auto">
                    <div class="body p-4">
                        <div>
                            @foreach($user->orders as $order)
                                {{verta($order->created_at)->format('d M Y')}}
                                <table class="w-full mx-auto table-auto text-center border-none">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تصویر</th>
                                        <th>محصول</th>
                                        <th>مقدار</th>
                                        <th>فی</th>
                                        <th>تعداد</th>
                                        <th>مجموع</th>
                                        <th>بیشتر</th>
                                    </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    @php($counter = 0)
                                    @foreach($orderItems as $item)
                                        <tr>
                                            <td>{{++$counter}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                </div>
                <br><br>
            </div>
        </div>
    </section>
@endsection
@section('script')

@endsection
