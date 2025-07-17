<header
    class="fixed z-50 top-9 right-0 left-0 hidden lg:flex items-center container h-24 mx-auto rounded-3xl py-5 backdrop-blur-[6px]">
    <div class="flex items-center justify-between w-full  text-navy-100 font-peyda">
        <nav class="flex gap-x-9 items-center h-14">
            <div class="flex gap-x-9">
                <img src="/home/image/logo.svg" alt="Nivor" class="w-[100px]">
            </div>
            <ul class="flex gap-x-5 2xl:gap-x-9 h-full child:leading-[56px]">
                <li>
                    <a href="/">خانه</a>
                </li>
                <li class="relative group">
                    <a href="/category/cycling-clothes" class="group-hover:text-orange-300">لباس دوچرخه سواری</a>
                    <div
                        class="absolute opacity-0 invisible group-hover:opacity-100 group-hover:visible top-full w-60 space-y-4 child:text-sm  text-zinc-700 dark:text-white bg-white p-6 dark:bg-zinc-700 rounded-2xl border-t-[3px] border-t-orange-300 transition-all child:block shadow-shadow child:transition-colors child-hover:text-orange-300">
                        <a href="/category/cycling-clothes">لباس دوچرخه سواری</a>
                        <a href="/category/cycling-jersey">پیراهن دوچرخه سواری</a>
                        <a href="/category/downhill-jersey">لباس دوچرخه سواری کوهستان</a>
                        <a href="/category/cycling-scarf">اسکارف دوچرخه سواری</a>
                    </div>
                </li>
                <li>
                    <a href="/category/wrestling-clothes">لباس کشتی</a>
                </li>
                {{--                <li>--}}
                {{--                    <a href="">لباس رشگارد</a>--}}
                {{--                </li>--}}
                {{--                <li>--}}
                {{--                    <a href="">لباس بدنسازی</a>--}}
                {{--                </li>--}}
                <li class="flex relative">
                    <a href="https://samur.ir" target="_blank">خرید کتونی</a>
                    <div class="absolute -left-4 -top-0 text-white bg-rose-500 rounded-sm text-xs p-[0.10rem]">جدید
                    </div>
                </li>
                <li>
                    <a href="tel:09352138605">تماس با ما</a>
                </li>
            </ul>
        </nav>
        <div class="flex gap-x-5 xl:gap-x-7">

            <div class="flex items-center gap-x-5">
                @if(!\Cart::isEmpty())
                    <div class="flex gap-x-5 relative">
                        <a href="/cart" aria-label="cart">
                            <svg class="w-7 h-7">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                        <div
                            class="absolute -right-4 -top-2 text-white bg-red-600 text-xs px-2 py-1 rounded-full">{{\Cart::getContent()->count()}}</div>
                    </div>
                @else
                    <div class="flex gap-x-5 relative">
                        <a href="/cart" aria-label="cart">
                            <svg class="w-7 h-7">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>


            @auth()
                <a href="/auth" class="flex items-center gap-x-2.5">
                    <svg class="w-7 h-7 rotate-180">
                        <use xlink:href="#auth"></use>
                    </svg>
                    <span class="hidden xl:inline-block">
                        {{auth()->user()->name != null ? auth()->user()->name ." ". auth()->user()->family : ''}} <br>
                        <span class="text-xs font-iransans">
                            {{number_format(auth()->user()->cashback)}}
                             <svg class="cashback-amount-menu">
                                    <use xlink:href="#tooman"></use>
                             </svg>
                        </span>
                    </span>

                </a>

            @else
                <a href="/auth" class="flex items-center gap-x-2.5">
                    <svg class="w-7 h-7 rotate-180">
                        <use xlink:href="#auth"></use>
                    </svg>
                    <span class="hidden xl:inline-block">ورود | ثبت نام</span>
                </a>
            @endauth

        </div>
    </div>
</header>

<div class="flex lg:hidden items-center justify-between bg-white dark:bg-zinc-700 px-4 h-16 mb-12">
    <div class="nav-icon">
        <svg class="w-6 h-6 text-zinc-700 dark:text-white">
            <use href="#menu"></use>
        </svg>
    </div>

    <div
        class="fixed nav top-0 bottom-0 -right-64 bg-white dark:bg-zinc-700 w-64 min-h-screen z-20 pt-3 px-4 transition-all overflow-y-auto">
        <div class="flex items-center justify-between pb-5 mb-6 border-b border-b-gray-100 dark:border-b-white/10">
            <div>
                <img src="/home/image/logo.svg" alt="نیور" class=" w-16">
            </div>
            <div class="close">
                <svg class="w-6 h-6 text-zinc-700 dark:text-white">
                    <use href="#close"></use>
                </svg>
            </div>
        </div>

        <div>
            <ul class="child:pr-2.5 space-y-6">
                <li>
                    <a href="/" class="flex items-center gap-x-2">
                        خانه
                    </a>
                </li>
                <li>
                    <div class="flex items-center justify-between submenu-btn">
                        <a href="#" class="flex items-center gap-x-2 submenu-btn">
                            لباس دوچرخه سواری
                        </a>
                        <span>
                                <svg class="w-6 h-6 text-zinc-700 dark:text-white">
                                    <use href="#down"></use>
                                </svg>
                            </span>
                    </div>
                    <div class="submenu">
                        <ul class="list-disc">
                            <li class="mt-4">
                                <a href="/category/cycling-clothes">لباس دوچرخه سواری</a>
                            </li>
                            <li class="mt-4">
                                <a href="/category/cycling-jersey">پیراهن دوچرخه سواری</a>
                            </li>
                            <li class="mt-4">
                                <a href="/category/downhill-jersey">لباس دوچرخه سواری کوهستان</a>
                            </li>
                            <li class="mt-4">
                                <a href="/category/cycling-scarf">اسکارف دوچرخه سواری</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="/category/wrestling-clothes">لباس کشتی</a>
                </li>
                {{--                <li>--}}
                {{--                    <a href="">لباس رشگارد</a>--}}
                {{--                </li>--}}
                <li>
                    <a href="https://samur.ir" target="_blank">خرید کتونی</a>
                </li>
            </ul>
        </div>


        <div
            class="space-y-6 mt-8 py-8 border-t border-t-gray-100 dark:border-t-white/10 text-zinc-700 dark:text-orange-300">
            @auth()
                <a href="/profile" class="flex items-center gap-x-2">
                    <svg class="w-7 h-7 rotate-180">
                        <use xlink:href="#auth"></use>
                    </svg>
                    <span>{{auth()->user()->name != null ? auth()->user()->name : ''}}</span>
                </a>
            @else
                <a href="/auth" class="flex items-center gap-x-2">
                    <svg class="w-7 h-7 rotate-180">
                        <use xlink:href="#auth"></use>
                    </svg>
                    <span>ورود | ثبت نام</span>
                </a>
            @endauth
            @if(!\Cart::isEmpty())
                <a href="/cart" class="flex items-center gap-x-2" aria-label="cart">
                    <svg class="w-7 h-7">
                        <use xlink:href="#cart"></use>
                    </svg>
                    <span>سبد خرید</span>
                </a>
            @else
                <a href="/cart" class="flex items-center gap-x-2" aria-label="cart">
                    <svg class="w-7 h-7">
                        <use xlink:href="#cart"></use>
                    </svg>
                    <span>سبد خرید</span>
                </a>
            @endif
            <a href="tel:09352138605" class="flex items-center gap-x-2">
                <svg class="w-7 h-7">
                    <use xlink:href="#call"></use>
                </svg>
                <span>تماس با پشتیبانی</span>
            </a>
        </div>


    </div>

    <div>
        <a href="/">
            <img src="/home/image/logo.svg" alt="نیور" class=" w-16">
        </a>
    </div>
    <div>
        <div class="relative">
            <a href="{{route('home.cart.index')}}">
                @if(! \Cart::isEmpty())
                    <div
                        class="absolute -right-4 -top-4 text-white bg-red-600 text-xs px-2 py-1 rounded-full">{{ \Cart::getContent()->count() }}</div>
                @endif
                <svg class="w-6 h-6 text-zinc-700 dark:text-white">
                    <use href="#cart"></use>
                </svg>
            </a>
        </div>
    </div>
</div>
