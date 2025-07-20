<section class="my-14 px-4">
    <div class="container mx-auto max-w-screen-xl">
        @foreach($bannerOne as $item)
            <a href="{{$item->link}}" target="_blank">
                <img class="rounded-2xl" src="/images/banner/{{$item->image}}" alt="{{$item->name}}">
            </a>
        @endforeach
    </div>
</section>
