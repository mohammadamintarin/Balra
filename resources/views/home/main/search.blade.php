<section class="search font-peyda">
    <div
        class="container overflow-y-hidden relative h-full flex justify-between items-center md:min-h-screen text-navy-100">
        <div class="flex flex-wrap justify-center">
            <div>
                <p class="text-4xl text-center mb-7">تجربه خرید کالای باکیفیت!</p>
                <p class="text-sm text-center mb-7">از بین بیش از ۵۰۰ کالا، کالای مورد نظر خود را انتخاب کنید.</p>
            </div>
            <div class="lg:w-[60%] w-[80%]">
                <form action="{{ route('home.search') }}" method="GET">
                    <div class="relative flex items-center">
                        <input type="text" class="h-14 mb-7 w-full px-3"name="search" placeholder="جستجو...">
                        <button class="absolute top-2 left-2 rounded-sm bg-green-400 px-2 py-2" type="submit" aria-label="search">
                            <svg class="w-6 h-6 text-white">
                                <use href="#search"></use>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="hidden md:flex justify-end">
            <img src="/home/image/home/header.webp" alt="جستجو در نیور">
        </div>
    </div>
</section>
