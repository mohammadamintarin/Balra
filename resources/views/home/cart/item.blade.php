<div class="mx-auto container justify-center  md:flex">
    <div class="rounded-lg md:w-2/3 ml-8 w-full">
        @foreach (\Cart::getContent() as $item)
            <div class="mb-4 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start border dark:bg-zinc-800">
                <div class="md:flex justify-between items-center justify-center">
                    <a href="{{ route('home.product.show' , ['category' => $item->associatedModel->category->slug,'product' => $item->associatedModel->slug]) }}">
                        <img src="/images/product/{{$item->associatedModel->image}}"
                             alt="product-image" class="w-full rounded-lg sm:w-40"/></a>
                    <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                        <div class="mt-5 sm:mt-0">
                            <h2 class="text-gray-900 dark:text-white">
                                <a href="{{ route('home.product.show' , ['category' => $item->associatedModel->category->slug,'product' => $item->associatedModel->slug]) }}">{{$item->name}}</a>
                            </h2>
                            <ul class="cart">
                                <li>
                                    <div class="flex items-center text-gray-700  dark:text-white">
                                        <svg class="w-4 h-4 text-gray-400">
                                            <use href="#cart"></use>
                                        </svg>
                                        <p class="mt-1 text-xs">{{$item->quantity}} عدد</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center  text-gray-700  dark:text-white">
                                        <svg class="w-4 h-4 text-gray-400">
                                            <use href="#size"></use>
                                        </svg>
                                        <p class="text-xs">{{ $item->attributes->value }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center  text-gray-700  dark:text-white">
                                        <svg class="w-4 h-4 text-gray-400">
                                            <use href="#money"></use>
                                        </svg>
                                        <p class="text-xs text-gray-700 flex items-center text-gray-700 dark:text-white">
                                            {{number_format($item->price)}}
                                            <svg class="w-3 h-3 text-gray-400">
                                                <use href="#tooman"></use>
                                            </svg>
                                        </p>
                                    </div>
                                </li>
                                @if($item->attributes->is_sale)
                                    <li>
                                        <div class="flex items-center  text-gray-700 dark:text-white">
                                            <svg class="w-4 h-4 text-gray-400">
                                                <use href="#gift"></use>
                                            </svg>
                                            <p class="mt-1 text-xs">
                                                ٪{{ $item->attributes->percent_sale }}
                                                تخفیف
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                <li>
                                    <div class="flex items-center  text-gray-700 dark:text-white">
                                        <svg class="w-4 h-4 text-gray-400">
                                            <use href="#shield"></use>
                                        </svg>
                                        <p class="text-xs"> گارانتی سلامت کالا</p>
                                    </div>
                                </li>

                                <li class="delete">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4">
                                            <use href="#trash"></use>
                                        </svg>
                                        <a class="text-xs" href="{{ route('home.cart.remove' , ['userID'=> auth()->user()->id , 'rowId' => $item->id]) }}">
{{--                                        <a class="text-xs" href="/remove-from-cart/{{$item->id}}">--}}
                                            <span class="text-xs">حذف از سبد خرید </span></a>
                                    </div>
                                </li>
                                <li class="quantity pt-8">
                                    <div class="flex items-center text-gray-700 dark:text-white">
                                        <p class="text-xs " style="margin-left: 15px;">تعداد : </p>
                                        @include('home.cart.quantity')
                                        {{--                                    <input class="form-control mx-5" type="text" name="qtybutton[{{ $item->id }}]" value="{{ $item->quantity }}" data-max="{{ $item->attributes->quantity }}">--}}
                                    </div>
                                </li>
                            </ul>
                            <br>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
