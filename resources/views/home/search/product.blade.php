@foreach($results as $product)
    <div class="item bg-white p-4 text-center rounded-md shadow-md mx-auto w-[90%] md:w-full my-2">
        <figure class="mb-4">
            <a href="{{route('home.product.show' , ['category' => $product->category->slug , 'product' => $product->slug])}}">
                <img src="{{url('/images/product') . '/' . $product->image}}" alt="{{$product->name}}">
            </a>
        </figure>
        <div class="title mb-3">
            <h2 class="text-navy-100 mb-2 text-sm">
                <a href="{{route('home.product.show' , ['category' => $product->category->slug , 'product' => $product->slug])}}"> {{\Illuminate\Support\Str::limit($product->name , 35)}} </a>
            </h2>
        </div>
        @if($product->quantity_check)
            @if($product->sale_check)
                <div class="meta my-5 text-xl">
                    <div class="flex justify-between">
                        <div class="new flex">
                            <p class="text-red-500 px-1 font-iransans">{{number_format($product->sale_check->sale_price)}}</p>
                            <svg class="w-4 h-4">
                                <use xlink:href="#tooman"></use>
                            </svg>
                        </div>
                        <div class="old flex">
                            <p class="text-gray-400 px-1 line-through font-iransans">{{number_format($product->price_check->price)}}</p>
                            <svg class="w-4 h-4">
                                <use xlink:href="#tooman"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            @else
                <div class="meta my-5 text-xl">
                    <div class="flex justify-center price">
                        <p class="text-red-500 px-1 font-iransans">{{number_format($product->price_check->price)}}</p>
                        <svg class="w-4 h-4">
                            <use xlink:href="#tooman"></use>
                        </svg>
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
