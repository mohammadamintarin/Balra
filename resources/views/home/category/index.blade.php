@extends('layout.app')
@section('meta')
    <title>{{$category->title}} | فروشگاه نیور </title>
    <meta name="description" content="{{$category->description}}">
    <meta property="og:title" content="{{$category->title}} | فروشگاه نیور "/>
    <meta property="og:description" content="{{$category->description}}"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/home/image/logo.svg"/>
    <meta name="twitter:title" content="{{$category->title}} | فروشگاه نیور "/>
    <meta name="twitter:description" content="{{$category->description}}"/>
    <script type="application/ld+json">
    {
     "@context": "https://schema.org",
     "@type": "BreadcrumbList",
     "itemListElement":
     [
      {
       "@type": "ListItem",
       "position": 1,
       "item":
       {
        "@id": "https://www.nivor.ir",
        "name": "خانه"
        }
      },
      {
       "@type": "ListItem",
      "position": 2,
      "item":
       {
         "@id": "/category/{{$category->slug}}",
         "name": "{{$category->name}}"
       }
      }
     ]
    }



    </script>

@endsection
@section('content')
    @include('home.category.header')
    <section class="product mt-10 font-peyda mb-20">
        <div class="container">
            <div class="grid lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-3 mb-4 rounded-lg">
                @include('home.category.product')
            </div>
            @include('home.category.content')
        </div>
    </section>
@endsection
@section('script')
    <script>
        function actionMoreLess() {
            var boxOuter = ".data_more_less",
                boxInner = ".data_more_less_inner",
                boxBody = ".data_more_less_body",
                showMore = $(".action_more"),
                showLess = $(".action_less");
            $(boxInner).each(function () {
                var $this = $(this),
                    bodyDataH = $this.find(boxBody).height();
                $this.css("max-height", $this.data("height"));
                var $thisH = $this.height();
                if (bodyDataH > $thisH) {
                    $this.closest(boxOuter).removeClass("action_disabled");
                } else {
                    $this.closest(boxOuter).addClass("action_disabled");
                }
            })
            showMore.click(function (e) {
                e.preventDefault();
                var $this = $(this),
                    boxInnerH = $this.closest(boxOuter).find(boxInner).height(),
                    boxInnerUpdate = boxInnerH + $this.closest(boxOuter).find(boxInner).data("increase-by"),
                    boxBodyH = $this.closest(boxOuter).find(boxBody).height();
                setTimeout(function () {
                    if (boxBodyH > boxInnerUpdate) {
                        $this.closest(boxOuter).removeClass("less_active").find(boxInner).css("max-height", boxInnerUpdate);
                    } else {
                        $this.closest(boxOuter).addClass("less_active").find(boxInner).css("max-height", "none");
                    }
                }, 10);
            });
            showLess.click(function () {
                $(this).closest(boxOuter).removeClass("less_active").find(boxInner).css("max-height", $(this).closest(boxOuter).find(boxInner).data("height"));
                return false;
            });
        }
        actionMoreLess();
    </script>
@endsection
