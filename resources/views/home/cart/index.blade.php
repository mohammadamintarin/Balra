@extends('layout.app')
@section('meta')
    <title>سبد خرید | فروشگاه نیور </title>
    <meta name="description" content="سبد خرید فروشگاه نیور">
    <meta property="og:title" content="سبد خرید فروشگاه نیور"/>
    <meta property="og:description" content="سبد خرید فروشگاه نیور"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/home/image/logo.svg"/>
    <meta name="twitter:title" content="سبد خرید فروشگاه نیور"/>
    <meta name="twitter:description" content="سبد خرید فروشگاه نیور"/>
@endsection
@section('content')
    <div class="mb-20 bg-gray-100 lg:pt-20 mt-24 dark:bg-zinc-800">
        @auth()
            @if(\Cart::isEmpty())
                @include('home.cart.empty')
            @else
                <h1 class="mb-10 text-center text-2xl font-bold dark:text-white">سبد خرید</h1>
                @include('home.cart.address')
                @if(count($addresses) > 0)
                    @include('home.cart.item')
                    @include('home.cart.buy')
                    <span style="display: none" id="temp">{{ cartTotalAmount()}}</span>

                @endif
            @endif
        @else
            @include('home.cart.login')

        @endauth
    </div>
@endsection
@section('script')
    @include('home.cart.modal')
    @include('home.cart.script')
@endsection

