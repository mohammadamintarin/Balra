@extends('layout.app')
@section('meta')
    <title>{{$product->title}} | فروشگاه نیور </title>
    <meta name="description" content="{{$product->description}}">
    <meta property="og:title" content="{{$product->title}} | فروشگاه نیور "/>
    <meta property="og:description" content="{{$product->description}}"/>
    <meta property="og:type" content="shop"/>
    <meta property="og:url" content="https://www.nivor.ir"/>
    <meta property="og:image:url" content="https://www.nivor.ir/images/product/{{$product->image}}"/>
    <meta name="twitter:title" content="{{$product->title}} | فروشگاه نیور "/>
    <meta name="twitter:description" content="{{$product->description}}"/>
    @if($product->canonical)
        <link rel="canonical" href="{{$product->canonical}}"/>
    @endif
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{$product->name}}",
      "description": "{{$product->description}}",
      "image": "/images/product/{{$product->image}}",
      "sku": "{{ $product->sku }}",
      "mpn": "{{ $product->sku}}",
      "brand": {
          "@type": "Brand",
          "name": "{{$product->brand->name}}",
          "url": "{{$product->brand->slug}}"
        },
      "review": {
					"@type": "Review",
					"reviewRating": {
						"@type": "Rating",
						"bestRating": 5,
						"ratingValue": {{ ceil($product->rates->avg('rate')) == 0 ? 1 : ceil($product->rates->avg('rate')) }},
						"worstRating": 0
					},
					"author": {
					    "@type": "Person",
					    "name": "خریدار محصول"
					}
				},
      "aggregateRating": {
					"@type": "AggregateRating",
					"ratingValue": {{ ceil($product->rates->avg('rate')) == 0 ? 1 : ceil($product->rates->avg('rate')) }},
					"reviewCount": {{ $product->approvedComments()->count() + 1}},
					"bestRating": 5,
					"worstRating": 1
				},
       "offers": {
					"@type": "AggregateOffer",
					"priceCurrency": "IRR",
					"lowPrice": {{$price}},
					"highPrice": {{$price}},
					"offerCount": 100,
					"offers": {
						"@type": "Offer",
						"priceCurrency": "IRR",
						"price": {{$price}},
						"itemCondition": "https://schema.org/NewCondition",
						"availability": "https://schema.org/InStock",
						"seller": {
							"@type": "Organization",
							"name": "Nivor"
						}
					}
				}
    }

    </script>
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
    "@id": "{{$product->category->slug}}",
    "name": "{{$product->category->name}}"
    }
  },
  {
   "@type": "ListItem",
  "position": 3,
  "item":
   {
     "@id": "{{$product->slug}}",
     "name": "{{$product->name}}"
   }
  }
 ]
}

    </script>
@endsection
@section('content')
    <div class="lg:mt-40 mt-0">
        <div class="lg:py-6 py-0">
            <div class="container">
                @include('home.product.breadcrumb')
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="flex flex-col md:flex-row -mx-4">
                        @include('home.product.gallery')
                        @include('home.product.buy')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('home.product.video')
    @include('home.product.related')
    @include('home.product.content')
    @include('home.product.comment')
    @include('home.product.size')
@endsection

@section('script')
    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        $(document).ready(function () {
            $('.thumbnails img').click(function (e) {
                e.preventDefault();
                $('.image-gallery img').attr('src', $(this).attr('src'));
            });
            $('.size').hide();
        });
        $('.variation-select').on('change', function () {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price');
            var img = $('<img class="w-6 h-6 dark:text-white">'); //Equivalent: $(document.createElement('img'))
            img.attr('src', '/app/image/tooman.svg');
            variationPriceDiv.empty();
            if (variation.is_sale) {
                let divSale = $('<div />', {
                    class: 'flex items-center text-3xl tracking-tight text-gray-900 dark:text-white price',
                    text: number_format(variation.sale_price),
                    itemprop: 'offers',
                    itemtype: 'https://schema.org/Offer',
                });
                let divPrice = $('<div />', {
                    class: 'flex items-center text-3xl tracking-tight text-gray-900 dark:text-white price',
                    text: number_format(variation.price),
                    itemprop: 'offers',
                    itemtype: 'https://schema.org/Offer',
                });
                variationPriceDiv.append(divSale);
                variationPriceDiv.append(divPrice);
            } else {
                let divPrice = $('<div />', {
                    class: 'flex items-center text-3xl tracking-tight text-gray-900 dark:text-white price',
                    text: number_format(variation.price),
                    itemprop: 'offers',
                    itemtype: 'https://schema.org/Offer',
                });
                variationPriceDiv.append(divPrice);
            }
            img.appendTo('.price');


        });

        function toggleModal() {
            $('.size').show();
        }

        $('#owl-related').owlCarousel({
            stagePadding: 5,
            rtl: true,
            dots: true,
            nav: false,
            autoplay: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: false,
                    loop: false,
                    margin: 20
                }
            }
        });


    </script>
@endsection
