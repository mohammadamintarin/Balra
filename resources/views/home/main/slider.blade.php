<section class="px-4">
    <div class="container mx-auto max-w-screen-xl">
        <div class="swiper main-slider">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <div class="swiper-slide">
                        <a href="{{$slider->link}}" target="_blank">
                            <img class="object-cover rounded-b-3xl w-full" src="/images/slider/{{$slider->image}}" alt="{{$slider->name}}">
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
