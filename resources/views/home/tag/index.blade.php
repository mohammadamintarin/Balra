@extends('layout.app')
@section('meta')
    <title>{{$tag->title}} | فروشگاه نیور </title>
    <meta name="description" content="{{$tag->description}}">
    <meta property="og:title" content="{{$tag->title}} | فروشگاه نیور "/>
    <meta property="og:description" content="{{$tag->description}}"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/home/image/logo.svg"/>
    <meta name="twitter:title" content="{{$tag->title}} | فروشگاه نیور "/>
    <meta name="twitter:description" content="{{$tag->description}}"/>
@endsection
@section('content')
    @include('home.tag.header')
    <section class="product mt-10 font-peyda mb-20">
        <div class="container">
            <div class="grid lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-3 mb-4 rounded-lg">
                @include('home.tag.product')
            </div>
        </div>
    </section>
@endsection
