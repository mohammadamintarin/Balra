@extends('layout.profile')
@section('content')
    <section class="mt-20 mb-20 lg:mt-40">
        <div class="container">
            <h2 class="text-2xl text-center mb-10">
                سفارش‌های شما
            </h2>
            @if ($orders->isEmpty())
                <div class="flex mx-auto max-w-6xl w-full px-6 dark:bg-zinc-800 dark:text-white">
                    <div class="mb-4 rounded py-6 bg-white px-6 shadow-md w-full md:flex justify-between items-center">
                        <div class="flex items-center">
                            <p class="px-2 text-center">
                                هنوز هیچ سفارشی ثبت نکرده اید.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @foreach ($orders as $order)
                <section class="courses font-iransans mt-10 mb-10">
                    <div class="container">
                        <div class="mb-8 lg:px-0 px-2">
                            @if($order->status == "delivered")
                                <img src="/home/image/icon/delivered.gif" alt="delivered" width="100px">
                                <h3 class="text-gray-700 mb-3 lg:text-3xl">به شادی استفاده کنید!</h3>
                                <p class="text-gray-500 mb-3 font-iransans text-sm">سفارش  با کد مرسوله  {{$order->code}}  تحویل  شد.</p>
                            @elseif($order->status == "sending")
                                <img src="/home/image/icon/post.gif" alt="post" width="100px">
                                <h3 class="text-gray-700 mb-3 lg:text-3xl text-xl">سفارش {{$order->id}} ارسال شده است!</h3>
                                <p class="text-gray-500 mb-3 font-iransans text-sm">سفارش شما با کد مرسوله {{$order->code}}  ارسال شده است.</p>
                            @elseif($order->status == "returned")
                                <img src="/home/image/icon/returned.gif" alt="returned" width="50px">
                                <h3 class="text-gray-700 mb-3 lg:text-3xl text-xl">سفارش {{$order->id}} لغو شده است!</h3>
                            @else
                                <img src="/home/image/icon/order.gif" alt="order" width="100px">
                                <h3 class="text-gray-700 mb-3 lg:text-3xl text-xl">در حال آماده سازی سفارش {{$order->id}} هستیم!</h3>
                                @if($order->date != null)
                                    <p class="text-gray-500 mb-3 font-iransans text-sm">تاریخ انتخابی شما برای ارسال: <span class="text-blue-600"><b>{{$order->date}}</b></span></p>
                                @endif
                                <p class="text-gray-500 mb-3 font-iransans text-sm">به محض ارسال، کد مرسوله پستی برای شما پیامک خواهد شد.</p>
                            @endif
                        </div>
                        <div id="owl-{{$order->id}}" class="owl-carousel owl-theme">
                            @foreach ($order->orderItems as $item)
                                <div class="item bg-white p-4 text-center rounded shadow-sm mx-auto lg:w-[90%] md:w-full">
                                    <figure class="mb-4">
                                        <img src="/images/product/{{$item->product->image }}" class="rounded order" alt="{{$item->product->name}}">
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
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            @foreach($orders as $order)
            $('#owl-' + {{$order->id}}).owlCarousel({
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
                        items: 2,
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
            @endforeach
        });
    </script>
@endsection
