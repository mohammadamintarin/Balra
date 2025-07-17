@if(count($articles) > 0)
<section class="blog mt-20">
    <div class="container">
        <div class="flex justify-between items-center lg:px-0 mb-10">
            <div class="flex items-center">
                <h3 class="text-gray-700 lg:text-3xl text-xl font-peyda">مقالات</h3>
            </div>
            <div class="flex items-center gap-x-3 text-gray-400 lg:text-xl text-sm">
                <a href="#">مشاهده همه</a>
                <svg class="w-5 h-5">
                    <use href="#arrow-left"></use>
                </svg>

            </div>
        </div>
        <div class="lg:grid lg:grid-cols-4 lg:gap-6">
            @foreach($articles as $article)
            <article class="relative mb-10 flex justify-between items-center lg:block">
                <a href="/blog/{{$article->slug}}" class="w-full h-full absolute top-0 left-0 z-10"></a>
                <div class="pl-4 lg:pl-0">
                    <img src="/images/article/{{$article->image}}" class="rounded mb-4 w-48 h-24 lg:w-full lg:h-full" alt="{{$article->name}}">
                </div>
                <div>
                    <a href="{{$article->blog->slug}}" class="text-xs font-iransans opacity-70">{{$article->blog->name}}</a>
                    <h2 class="leading-relaxed opacity-80 py-2">{{\Illuminate\Support\Str::limit($article->name , 35)}}</h2>
                    <span class="text-xs font-iransans opacity-70">
                                {{verta($article->created_at)->formatDifference()}}
{{--                                •--}}

                            </span>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
