@extends('layout.app')
@section('meta')
    <title>{{$article->title}} | فروشگاه نیور </title>
    <meta name="description" content="{{$article->description}}">
    <meta property="og:title" content="{{$article->title}} | فروشگاه نیور "/>
    <meta property="og:description" content="{{$article->description}}"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/images/article/{{$article->image}}"/>
    <meta name="twitter:title" content="{{$article->title}} | فروشگاه نیور "/>
    <meta name="twitter:description" content="{{$article->description}}"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "headline": "{{$article->name}}",
      "image":"https://www.nivor.ir/image/article/{{$article->image}}",
      "datePublished": "{{verta($article->created_at)->formatGregorian('Y-n-j H:i')}}",
      "dateModified": "{{verta($article->updated_at)->formatGregorian('Y-n-j H:i')}}",
      "author": [{
          "@type": "Person",
          "name": "{{$article->user->name . ' ' . $article->user->family}}",
          "url": "https://www.nivor.ir"
        },{
          "@type": "Person",
          "name": "{{$article->user->name . ' ' . $article->user->family}}",
          "url": "https://www.nivor.ir"
      }]
    }
    </script>
@endsection
@section('content')
    <section class="lg:mt-40 mt-20">
        <div class="container cover lg:flex lg:items-center lg:justify-between mb-10">
            <div class="pl-5 mb-4">
                <a href="/category/{{$article->blog->slug}}" class="text-gray-500 text-sm">{{$article->blog->name}}</a>
                <h1 class="lg:text-4xl text-3xl leading-10 my-4 lg:my-6 font-peyda leading-10">{{$article->name}}</h1>
                <span class="text-sm text-gray-500">
                   <a itemprop="url" href="#">
                    <span itemprop="name">{{$article->user->name . ' ' . $article->user->family}}</span>
                   </a>
                   •
                  {{verta($article->created_at)->formatDifference()}}
                </span>
            </div>
            <div>
                <img src="/images/article/{{$article->image}}" class="rounded-md" alt="{{$article->name}}">
            </div>
        </div>
        <div class="container mb-20">
            <div class="content leading-10 text-zinc-700">
                {!! $article->content !!}
            </div>
        </div>
    </section>
@endsection
