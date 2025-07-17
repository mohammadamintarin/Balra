@extends('layout.profile')
@section('content')
    <section class="mt-20 mb-20 lg:mt-40">
        <div class="container">
            <h2 class="text-2xl text-center mb-10">
                سفارش‌های شما
            </h2>
            @if ($wishlists->isEmpty())
                <div class="flex mx-auto max-w-6xl w-full px-6 dark:bg-zinc-800 dark:text-white">
                    <div class="mb-4 rounded py-6 px-6 w-full md:flex justify-between items-center">
                        <div class="flex items-center">
                            <p class="px-2 text-center">
                                هنوز هیچ محصولی به لیست اضافه نکرده‌اید.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @foreach ($wishlists as $item)
                <section class="courses font-iransans mt-10 mb-10">
                    <div class="container">
                        <div>
                            <div class="item bg-white p-4 text-center rounded shadow-sm mx-auto lg:w-[90%] md:w-full">
                                <figure class="mb-4">
                                    <img src="/images/product/{{$item->image }}" class="rounded order"
                                         alt="{{$item->name}}">
                                </figure>
                                <div class="title mb-3">
                                    <h2 class="text-navy-100 mb-2 text-sm font-iransans">
                                        <a href="{{ route('home.product.show' , ['category' => $item->product->category->slug ,'product' => $item->product->slug]) }}">
                                            {{\Illuminate\Support\Str::limit($item->product->name , 35)}}
                                        </a>
                                    </h2>
                                </div>
                                <div class="meta grid grid-cols-3 gap-x-2 my-5 text-sm">
                                    <div class="student mx-auto gap-y-3">
                                        <div>
                                            <svg class="w-6 h-6 mx-auto  text-gray-500">
                                                <use href="#stack"></use>
                                            </svg>
                                        </div>
                                        <div class="my-3">
                                            <p class="font-peyda text-gray-800">تعداد</p>
                                        </div>
                                        <div>
                                            <p>{{$item->quantity}}</p>
                                        </div>
                                    </div>
                                    <div class="price border border-y-0 border-x-2 border-dashed mx-auto ">
                                        <div class="px-4">
                                            <svg class="w-6 h-6 mx-auto text-gray-500">
                                                <use href="#money"></use>
                                            </svg>
                                            <div class="my-3">
                                                <p class="font-peyda text-gray-800">مبلغ</p>
                                            </div>
                                            <p class="text-red-600">{{ number_format($order->paying_amount) }}</p>
                                        </div>
                                    </div>
                                    <div class="episode mx-auto">
                                        <svg class="w-6 h-6 mx-auto text-gray-500">
                                            <use href="#size"></use>
                                        </svg>
                                        <div class="my-3">
                                            <p class="font-peyda text-gray-800">سایز</p>
                                        </div>
                                        <p>
                                            {{ \App\Models\ProductVariation::find($item->product_variation_id)->value }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
        </div>
    </section>
@endsection
