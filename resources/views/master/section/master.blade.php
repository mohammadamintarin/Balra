<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    @include('master.section.meta')
    @include('master.section.style')
    @yield('style')
</head>
<body class="font-iransans dark:bg-zinc-800">
@include('master.section.svg')
@include('master.section.menu')
<main class="mt-52">
@yield('content')
</main>
<div class="overlay"></div>
@include('master.section.script')
@yield('script')
</body>
</html>
