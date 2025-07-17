<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
@include('home.layout.meta')
    <title>Nivor</title>
@include('home.layout.style')
</head>
<body class="font-iransans bg-gray-100 dark:bg-zinc-800">
@include('home.layout.svg')
@include('home.layout.menu')
<main class="px-3">
@yield('content')
</main>
<div class="overflow-x-hidden"></div>
<div class="overlay"></div>
<div class="fixed lg:hidden bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
        <a href="/" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400"><use xlink:href="#home"></use></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400">خانه</span>
        </a>
        <a href="/profile/order" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400"><use xlink:href="#receipt"></use></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400">سفارش‌ها</span>
        </a>
        <a href="/profile/comment" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400"><use xlink:href="#comment"></use></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400">نظرات</span>
        </a>
        <a href="/profile" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-1 text-gray-500 dark:text-gray-400"><use xlink:href="#profile"></use></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400">پروفایل</span>
        </a>
    </div>
</div>
@include('home.layout.script')
</body>
</html>
