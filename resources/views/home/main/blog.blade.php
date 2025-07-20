<section class="my-14 px-4">
    <div class="container mx-auto max-w-screen-xl">
        <div class="text-center mb-8">
            <h2 class="font-YekanBakh-ExtraBlack text-3xl">خواندنی های جدید</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($articles as $item)
            <div class="bg-white p-4 rounded-3xl">
                <div class="relative">
                    <a href="/blog/{{$item->slug}}">
                        <img class="rounded-2xl" src="/images/article/{{$item->image}}" alt="{{$item->name}}">
                    </a>
                    <div class="absolute top-4 left-4 bg-white border-t-4 border-yellow-400 p-2 px-3 rounded-xl">
                        <div class="flex flex-col">
                            <span class="font-YekanBakh-ExtraBold text-2xl">{{verta($item->created_at)->format("d")}}</span>
                            <span class="font-YekanBakh-Bold text-center">{{verta($item->created_at)->format("M")}}</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <div>
                        <a href="/blog/{{$item->slug}}"><h3 class="font-YekanBakh-ExtraBold text-base">{{$item->name}}</h3></a>
                    </div>
                    <div>
                        <a class="flex items-center" href="/blog/{{$item->slug}}">
                            <span class="ml-2">بیشتر</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
