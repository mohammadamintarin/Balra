@if($offers)
<section class="product font-peyda mt-20">
    <div class="container">
        <div class="flex justify-between items-center lg:px-0 px-2 mb-10">
            <div class="flex items-center">
                <img src="/home/image/icon/offer.gif" alt="تخفیف نیور" class="w-8 lg:w-12 pl-2">
                <h3 class="text-gray-700 lg:text-3xl text-xl">با تخفیف ببر</h3>
            </div>
            <div class="flex items-center gap-x-3 text-gray-400 lg:text-xl text-sm">
{{--                <a href="#">مشاهده همه</a>--}}
{{--                <svg class="w-5  h-5">--}}
{{--                    <use href="#arrow-left"></use>--}}
{{--                </svg>--}}

            </div>
        </div>
        <div id="owl-two" class="owl-carousel owl-theme">
            @foreach($offers as $item)
            <div class="item bg-white p-4 text-center rounded-md shadow-md mx-auto w-[90%] md:w-full my-2">
                <figure class="mb-4">
                    <a href="{{route('home.product.show' , ['category' => $item->category->slug , 'product' => $item->slug])}}">
                        <img src="{{url('/images/product') . '/' . $item->image}}" alt="{{$item->name}}">
                    </a>
                </figure>
                <div class="title mb-3">
                    <h2 class="text-navy-100 mb-2 text-sm">
                        <a href="{{route('home.product.show' , ['category' => $item->category->slug , 'product' => $item->slug])}}">{{\Illuminate\Support\Str::limit($item->name , 35)}}</a>
                    </h2>
                </div>
                @if($item->quantity_check)
                    @if($item->sale_check)
                <div class="meta my-5 text-xl">
                    <div class="flex justify-between">
                        <div class="new flex">
                            <p class="text-red-500 px-1 font-iransans">{{number_format($item->sale_check->sale_price)}}</p>
                            <svg class="w-4 h-4"><use xlink:href="#tooman"></use></svg>
                        </div>
                        <div class="old flex">
                            <p class="text-gray-400 px-1 line-through font-iransans">{{number_format($item->price_check->price)}}</p>
                            <svg class="w-4 h-4"><use xlink:href="#tooman"></use></svg>
                        </div>
                    </div>
                </div>
                    @else
                <div class="meta my-5 text-xl">
                    <div class="flex justify-center price">
                        <p class="text-red-500 px-1 font-iransans">{{number_format($item->price_check->price)}}</p>
                        <svg class="w-4 h-4"><use xlink:href="#tooman"></use></svg>
                    </div>
                </div>
                    @endif
                @else
                    <div class="meta my-5 text-xl">
                        <div class="flex justify-center price">
                            <p class="text-red-500 px-1 font-iransans">ناموجود</p>
                        </div>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
