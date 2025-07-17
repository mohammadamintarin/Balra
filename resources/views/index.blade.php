@extends('layout.app')
@section('meta')
    <title>فروشگاه نیور</title>
    <meta name="description" content="خرید محصولات ورزشی با کیفیت از فروشگاه نیور با پرداخت قسطی و یا آنلاین با قیمت مناسب و ارسال رایگان به سراسر ایران">
    <meta property="og:title" content="فروشگاه نیور"/>
    <meta property="og:description" content="خرید محصولات ورزشی با کیفیت از فروشگاه نیور با پرداخت قسطی و یا آنلاین با قیمت مناسب و ارسال رایگان به سراسر ایران"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/home/image/logo.webp"/>
    <meta name="twitter:title" content="فروشگاه نیور"/>
    <meta name="twitter:description" content="خرید محصولات ورزشی با کیفیت از فروشگاه نیور با پرداخت قسطی و یا آنلاین با قیمت مناسب و ارسال رایگان به سراسر ایران"/>
@endsection
@section('content')
@include('home.main.search')
@include('home.main.snapp')
@include('home.main.sectionOne')
@include('home.main.social')
@include('home.main.wrestling')
@include('home.main.sectionTwo')
@include('home.main.article')
@include('home.main.faq')
@endsection
@include('home.main.script')
