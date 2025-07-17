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
                        افزودن کدتخفیف
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#coupon"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.coupon.store')}}" method="POST">
                    @csrf
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>عنوان</label>
                                <input type="text" name="name" value="{{old('name')}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>کد</label>
                                <input type="text" name="code" value="{{old('code')}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>تاریخ انقضا</label>
                                <div class="input-group flex">
                                    <div class="input-group-prepend order-2" style="height: 38px">
                                         <span class="input-group-text" id="expireDate">
                                               <svg class="w-4 h-4"><use href="#time"></use></svg>
                                         </span>
                                    </div>
                                    <div style="width: 85%">
                                        <input  id="expireInput" type="text" class="form-control" name="expire_at">
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label> نوع</label>
                                <select name="type" >
                                    <option value="amount">ریالی</option>
                                    <option value="percentage">درصدی</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label>مبلغ</label>
                                <input type="text" name="amount" value="{{old('amount')}}">
                            </div>
                            <div class="sm:col-span-2">
                                <label>درصد </label>
                                <input type="text" name="percentage" value="{{old('percentage')}}">
                            </div>
                            <div class="sm:col-span-2">
                                <label>حداکثر مبلغ </label>
                                <input type="text" name="max_percentage_amount" value="{{old('max_percentage_amount')}}">
                            </div>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search"></div>
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
    <script src="/admin/js/mds.bs.datetimepicker.js"></script>
    <script>
        $('#expireDate').MdPersianDateTimePicker({
            targetTextSelector: '#expireInput',
            textFormat: 'yyyy-MM-dd HH:mm:ss',
            enableTimePicker: true,
            englishNumber: true
        });
    </script>
@endsection
