<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    @include('home.layout.meta')
    @yield('meta')
    @include('home.layout.style')
</head>
<body class="bg-slate-50 font-YekanBakh-Regular text-sm">
@include('home.layout.svg')
<div class="header-cover"></div>
@include('home.layout.menu')
@yield('content')
@include('home.main.footer')
@include('home.layout.script')
</body>
</html>
