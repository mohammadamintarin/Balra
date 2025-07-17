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
                        ویرایش سوال
                    </div>
                </div>
                <form action="{{route('master.faq.update' , ['faq' => $faq->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>سوال</label>
                                <input type="text" name="question" value="{{$faq->question}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>پاسخ</label>
                                <input type="text" name="answer" value="{{$faq->answer}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>نوع</label>
                                <select name="type">
                                    <option value="rule" {{$faq->type == 'rule' ? 'selected' : ' '}}>قوانین</option>
                                    <option value="send" {{$faq->type == 'send' ? 'selected' : ' '}}>ارسال</option>
                                    <option value="payment" {{$faq->type == 'payment' ? 'selected' : ' '}}>پرداخت</option>
                                    <option value="paypal" {{$faq->type == 'paypal' ? 'selected' : ' '}}>پی‌پال</option>
                                    <option value="politic" {{$faq->type == 'politic' ? 'selected' : ' '}}>سیاست‌کلی</option>
                                    <option value="privacy" {{$faq->type == 'privacy' ? 'selected' : ' '}}>حریم‌خصوصی</option>
                                    <option value="about" {{$faq->type == 'about' ? 'selected' : ' '}}>درباره‌ما</option>
                                    <option value="general" {{$faq->type == 'general' ? 'selected' : ' '}}>عمومی</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
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
