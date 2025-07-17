@extends('layout.app')
@section('meta')
    <title>سوالات  متداول | فروشگاه نیور </title>
    <meta name="description" content="سوالات  متداول کاربران از فروشگاه نیور">
    <meta property="og:title" content="سوالات متداول | فروشگاه نیور "/>
    <meta property="og:description" content="سوالات  متداول کاربران از فروشگاه نیور"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/home/image/logo.svg"/>
    <meta name="twitter:title" content="سوالات  متداول | فروشگاه نیور "/>
    <meta name="twitter:description" content="سوالات  متداول کاربران از فروشگاه نیور"/>
@endsection
@section('content')
    <section class="faq bg-faq bg-cover lg:mt-28 lg:pt-40">
        <div class="container">
            <div class="text-center mb-16">
                <h1 class="text-gray-700 text-3xl font-peyda title">سوالات متداول</h1><br>
            </div>
            <div id="about">
                <h6 class="text-xl font-peyda text-gray-700">
                    درباره نیور
                </h6><br>
                <div class="faq-items mb-20">
                    @foreach($abouts as $faq)
                        <div x-data="{ open: false}"
                             class=" py-2 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer">
                            <div @click="open = ! open"
                                 class="p-6 bg-white w-full rounded flex justify-between items-center relative">

                                <div class="absolute -bottom-10 right-0">
                                    <svg class="w-[3.9rem]">
                                        <use href="#faq"></use>
                                    </svg>
                                </div>
                                <div class="lg:px-[60px] px-5">
                                    <p>{{$faq->question}}</p>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-0"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 translate-y-10"
                                 x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white p-4 leading-8">
                                <p class="text-md text-slate-600 leading-9">{{$faq->answer}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="term">
                <h6 class="text-xl font-peyda text-gray-700">
                    قوانین و حریم خصوصی
                </h6><br>
                <div class="faq-items mb-20">
                    @foreach($terms as $faq)
                        <div x-data="{ open: false}"
                             class=" py-2 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer">
                            <div @click="open = ! open"
                                 class="p-6 bg-white w-full rounded flex justify-between items-center relative">

                                <div class="absolute -bottom-10 right-0">
                                    <svg class="w-[3.9rem]">
                                        <use href="#faq"></use>
                                    </svg>
                                </div>
                                <div class="lg:px-[60px] px-5">
                                    <p>{{$faq->question}}</p>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-0"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 translate-y-10"
                                 x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white p-4 leading-8">
                                <p class="text-md text-slate-600 leading-9">{{$faq->answer}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="send">
                <h6 class="text-xl font-peyda text-gray-700">
                    ثبت سفارش و ارسال کالا
                </h6><br>
                <div class="faq-items mb-20">
                    @foreach($sends as $faq)
                        <div x-data="{ open: false}"
                             class=" py-2 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer">
                            <div @click="open = ! open"
                                 class="p-6 bg-white w-full rounded flex justify-between items-center relative">

                                <div class="absolute -bottom-10 right-0">
                                    <svg class="w-[3.9rem]">
                                        <use href="#faq"></use>
                                    </svg>
                                </div>
                                <div class="lg:px-[60px] px-5">
                                    <p>{{$faq->question}}</p>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-0"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 translate-y-10"
                                 x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white p-4 leading-8">
                                <p class="text-md text-slate-600 leading-9">{{$faq->answer}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="return">
                <h6 class="text-xl font-peyda text-gray-700">
                    رویه‌های بازگرداندن کالا
                </h6><br>
                <div class="faq-items mb-20">
                    @foreach($returns as $faq)
                        <div x-data="{ open: false}"
                             class=" py-2 flex flex-col items-center justify-center relative overflow-hidden cursor-pointer">
                            <div @click="open = ! open"
                                 class="p-6 bg-white w-full rounded flex justify-between items-center relative">

                                <div class="absolute -bottom-10 right-0">
                                    <svg class="w-[3.9rem]">
                                        <use href="#faq"></use>
                                    </svg>
                                </div>
                                <div class="lg:px-[60px] px-5">
                                    <p>{{$faq->question}}</p>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div x-show="open" @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 translate-y-0"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 translate-y-10"
                                 x-transition:leave-end="opacity-0 translate-y-0" class="w-full bg-white p-4 leading-8">
                                <p class="text-md text-slate-600 leading-9">{{$faq->answer}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
