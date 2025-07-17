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
    <div class="container">
        @yield('content')
    </div>
</main>
<div class="overlay"></div>
@include('master.section.script')
</body>
</html>
