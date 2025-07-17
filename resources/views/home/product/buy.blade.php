<div class="md:flex-1 pl-2">
    <h1 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl">{{$product->name}}</h1>
    <div class="text-gray-500 px-4 mb-4">
        <ul role="list" class="list-disc space-y-2 pl-4 text-sm">

            @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                <li class="text-gray-400"><span class="text-gray-600">{{ $attribute->attribute->name }}: <span
                        >{{ $attribute->value }}</span></span></li>
            @endforeach
            <li class="text-gray-400"><a href="/brand/{{$product->brand->slug}}" target="_blank"><span
                        class="text-indigo-600 hover:underline">{{$product->brand->name}} | {{$product->brand->en}}</span></a>
            </li>
        </ul>
    </div>
    <form action="{{route('home.cart.add')}}" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <div class="mt-4 lg:row-span-3 dark:text-white lg:mt-10">
            <div class="flex items-center justify-between">
                <div class="variation-price flex">
                    @if($product->quantity_check)
                        @if($product->sale_check)
                            <div class="flex items-center text-3xl tracking-tight text-red-500 dark:text-white">
                                {{number_format($product->sale_check->sale_price)}}
                                <svg class="w-6 h-6 dark:text-white">
                                    <use xlink:href="#tooman"></use>
                                </svg>
                            </div>
                            <div
                                class="flex items-center text-3xl tracking-tight text-gray-500 dark:text-white text-xl px-2"
                                itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                                <del> {{ number_format($product->sale_check->price) }}</del>
                                <svg class="w-6 h-6 dark:text-white">
                                    <use xlink:href="#tooman"></use>
                                </svg>
                            </div>
                        @else
                            <div class="flex items-center text-3xl tracking-tight text-gray-900 dark:text-white"
                                 itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                                {{   number_format($product->price_check->price)   }}
                                <svg class="w-6 h-6 dark:text-white">
                                    <use xlink:href="#tooman"></use>
                                </svg>
                            </div>
                        @endif
                    @else
                        <div class="flex items-center text-3xl tracking-tight text-gray-900 dark:text-white"
                             itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
                            ناموجود ):
                        </div>
                    @endif
                </div>
                <div class="flex items-center">
                    <img src="/home/image/icon/free-delivery.gif" alt="ارسال رایگان در نیور" class="w-10 mb-3">
                    <p> ارسال رایگان</p>
                </div>
            </div>
            <div class="flex mt-6">
                <a href="#sizing" class="mx-auto text-indigo-600 hover:underline" onclick="toggleModal()">راهنمای انتخاب سایز</a>
            </div>
            @if($product->quantity_check)
                @php
                    if($product->sale_check)
                    {
                        $variationProductSelected = $product->sale_check;
                    }else{
                        $variationProductSelected = $product->price_check;
                    }
                @endphp
                <div class="flex items-center justify-between  mt-6">
                    <div class="grow">
                        <fieldset class="mt-4">
                            <select name="variation" class="w-full py-3 px-3 variation-select">
                                @foreach ($product->variations()->where('quantity' , '>' , 0)->get() as $variation)
                                    <option
                                        value="{{ json_encode($variation->only(['id' , 'quantity','is_sale' , 'sale_price' , 'price'])) }}"
                                        {{ $variationProductSelected->id == $variation->id ? 'selected' : '' }}>
                                        {{ $variation->value }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                    <div>
                        <input name="quantity" type="number" value="1" data-max="25" placeholder="1"
                               class="mt-4 w-[100px] mr-4 rounded-md border-0 px-3.5 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
                <button type="submit"
                        class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    افزودن به سبد خرید
                </button>
            @endif
        </div>
    </form>
</div>
