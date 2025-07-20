<section class="my-14 px-4">
    <div class="container mx-auto max-w-screen-xl">
        <div class="text-center mb-8">
            <h2 class="font-YekanBakh-ExtraBlack text-3xl">جدیدترین محصولات</h2>
        </div>
        <div class="swiper slider-product1">
            <div class="swiper-wrapper">
                @foreach($latests as $item)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-3xl leading-10 p-4">
                            <div class="relative">
                                <a href="{{route('home.product.show' , ['category' => $item->category->slug , 'product' => $item->slug])}}"
                                   class="flex flex-col items-center justify-center">
                                    <img class="mb-4"
                                         src="{{url('/images/product') . '/' . $item->image}}"
                                         alt="{{$item->name}}">
                                </a>
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
</section>
