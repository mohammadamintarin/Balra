<section class="faq bg-faq bg-cover my-20">
    <div class="container">
        <div class="text-center mb-16">
            <h3 class="text-gray-700 text-3xl font-peyda title">سوال دارید؟ از ما بپرسید...</h3>
        </div>
        <div class="faq-items mb-20">
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
                        <p>
                            داستان نیور
                        </p>
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
                    <p class="text-md text-slate-600 leading-9">

                        فروشگاه اینترنتی نیوُر در سال 1400 متولد شد و با تکیه بر تجربه 20 ساله خود در زمینه تولید لباس ورزشی، می تواند کالاهای متنوع، باکیفیت و دارای قیمت مناسب را در مدت زمان کوتاه به دست مشتریان خود برساند. از ویژگی های مهم این فروشگاه ضمانت بازگشت کالا می باشد که با توجه به قوانین آن مشتریان می توانند به راحتی اقدام به ثبت مرجوعی کالای خریداری شده کنند.

                    </p>
                </div>
            </div>
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
                        <p>

                            امکان خرید عمده برای گروه وجود دارد؟

                        </p>
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
                    <p class="text-sm text-slate-600 leading-9">

                        شما عزیزان می توانید با کلیک بر روی نماد اعتبار الکترونیک در انتهای سایت از صحت اطلاعات فروشگاه مطمئن شوید.

                    </p>
                </div>
            </div>
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
                        <p>
                            چطوری در سایت ثبت نام کنیم؟
                        </p>
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
                    <p class="text-sm text-slate-600 leading-9">

                        بله امکان خرید لباس با طراحی اختصاصی برای تیم‌ها و گروه‌ها وجود دارد، برای این منظور با شماره 09351365868 تماس حاصل فرمایید.

                    </p>
                </div>
            </div>
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
                        <p>
                            خرید حضوری از نیور امکان‌پذیر است؟
                        </p>
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
                    <p class="text-sm text-slate-400 leading-9">

                        دفتر مرکزی نیور در تهران است اما متاسفانه فعلا فروش حضوری از نیور امکان پذیر نمی باشد، اما برای رفاه حال کاربران امکان تعویض سایز و مرجوعی قرار داده شده است تا دیگر نگرانی از بابت خرید اینترنتی وجود نداشته باشد.

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
