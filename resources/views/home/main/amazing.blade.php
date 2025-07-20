@if($offers)
    <section class="my-14 px-4">
        <div class="container mx-auto max-w-screen-xl">
            <div class="bg-yellow-500 rounded-3xl pt-10 pb-4">
                <div class="text-center mb-8">
                    <h2 class="font-YekanBakh-ExtraBlack text-3xl">پیشنهاد شگفت انگیز</h2>
                </div>
                <div class="grid grid-cols-12 gap-4 p-4">
                    <div class="col-span-12 lg:col-span-9">
                        <div class="swiper off-product">
                            <div class="swiper-wrapper">
                                @foreach($offers as $item)
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-3xl leading-10 p-4">
                                            <div class="relative">
                                                <a href="{{route('home.product.show' , ['category' => $item->category->slug , 'product' => $item->slug])}}"
                                                   class="flex flex-col items-center justify-center">
                                                    <img class="mb-4"
                                                         src="{{url('/images/product') . '/' . $item->image}}"
                                                         alt="{{$item->name}}">
                                                </a>
                                                <div
                                                    class="bg-yellow-500 absolute top-2 right-2 rounded-full w-10 h-10">
                                                    <p class="flex items-center justify-center">30%</p>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <a href="{{route('home.product.show' , ['category' => $item->category->slug , 'product' => $item->slug])}}">
                                                    <h3
                                                        class="font-YekanBakh-ExtraBold text-base">{{\Illuminate\Support\Str::limit($item->name , 28)}}</h3>
                                                </a>
                                                @if($item->quantity_check)
                                                    @if($item->sale_check)
                                                        <div class="flex justify-center gap-4 text-base mt-4">
                                                            <span class="line-through">{{number_format($item->price_check->price)}} تومان</span>
                                                            <span class="text-yellow-500">{{number_format($item->sale_check->sale_price)}} تومان</span>
                                                        </div>
                                                    @else
                                                        <div class="flex justify-center gap-4 text-base mt-4">
                                                            <span>{{number_format($item->price_check->price)}} تومان</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="flex justify-center gap-4 text-base mt-4">
                                                        <span>ناموجود</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="hidden lg:block lg:col-span-3">
                        <div class="bg-stone-800 rounded-3xl p-4">
                            <div class="flex flex-col leading-8">
                                <p class="text-white text-center">با تخفیف شگفتانه محصول خود را خریداری کنید :)</p>
                                <div class="flex justify-center my-12">
                                    <img class="w-48" src="/home/images/off.png" alt="تخفیف شگفت انگیز">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
