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
                        تغییر قیمت
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#increase"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.increase.store')}}" method="POST">
                    @csrf
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class="row">
                            <div class="col-md-4">
                                <label>مقدار</label>
                                <input type="text" name="value" value="{{old('value')}}">
                            </div>
                            <div class="col-md-4">
                                <label>درصد</label>
                                <input type="text" name="percent" value="{{old('percent')}}">
                            </div>
                            <div class="col-md-4">
                                <label>نوع</label>
                                <select name="status" required>
                                    <option value="">-</option>
                                        <option value="increase">افزایش قیمت</option>
                                        <option value="decrease">کاهش قیمت</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>دسته‌بندی</label>
                                <select name="category_id">
                                    <option value="">-</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>برند</label>
                                <select name="brand_id">
                                    <option value="">-</option>
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>مدل</label>
                                <select name="type_id">
                                    <option value="">-</option>
                                    @foreach($models as $model)
                                        <option value="{{$model->id}}">{{$model->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <p class="text-red-700">
                            در نظر داشته باشید  که در هربار برای یکی از موارد دسته‌بندی، برند و یا مدل اقدام به افزایش قیمت کنید.
                        </p>
                        <br>
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
        $('#startDate').MdPersianDateTimePicker({
            targetTextSelector: '#startInput',
            textFormat: 'yyyy-MM-dd HH:mm:ss',
            enableTimePicker: true,
            englishNumber: true
        });
        $('#expireDate').MdPersianDateTimePicker({
            targetTextSelector: '#expireInput',
            textFormat: 'yyyy-MM-dd HH:mm:ss',
            enableTimePicker: true,
            englishNumber: true
        });
    </script>
@endsection
