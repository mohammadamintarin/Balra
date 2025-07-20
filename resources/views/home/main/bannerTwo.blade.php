<section class="my-14 px-4">
    <div class="container mx-auto max-w-screen-xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($bannerTwo as $item)
                <div>
                    <a href="{{$item->link}}" target="_blank">
                        <img class="rounded-3xl" src="/images/banner/{{$item->image}}" alt="{{$item->name}}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
