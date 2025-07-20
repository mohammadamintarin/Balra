
<section class="my-14 px-4">
    <div class="container mx-auto max-w-screen-xl">
        <div class="text-center mb-8">
            <h2 class="font-YekanBakh-ExtraBlack text-3xl">دسته بندی محصولات</h2>
        </div>
        <div class="swiper cat-slider">
            <div class="swiper-wrapper">
                @foreach($categorySlider as $item)
                <div class="swiper-slide">
                    <div class="border border-slate-200 bg-white rounded-3xl leading-10">
                        <a href="{{$item->link}}" class="flex flex-col items-center justify-center p-4">
                            <img class="w-16 mb-4" src="/images/slider/{{$item->image}}" alt="{{$item->name}}">
                            <h3 class="font-YekanBakh-ExtraBold text-base">{{$item->name}}</h3>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>

        </div>
    </div>
</section>
