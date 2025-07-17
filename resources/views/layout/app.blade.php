<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    @include('home.layout.meta')
    @yield('meta')
    @include('home.layout.style')
</head>
<body class="font-iransans bg-gray-100 dark:bg-zinc-800">
@include('home.layout.svg')
<div class="header-cover"></div>
@include('home.layout.menu')
<main class="px-3">
    @yield('content')
    @include('home.layout.footer')
</main>
<div class="overflow-x-hidden"></div>
<div class="overlay"></div>
@include('home.layout.script')
</body>
</html>
