@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl" style="color: {{ $order->payment_status == 1 ? 'green' : 'red' }}">
                        # سفارش
                        {{$order->id}}
                    </div>
                    <div>
                        @if($order->payment_status == 1)
                            <a class="group relative inline-block px-1"
                               href="{{route('master.order.change.to.fail' , ['order' => $order->id ])}}">
                                <svg class="w-7 h-7">
                                    <use href="#fail"></use>
                                </svg>
                                <div
                                    class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                    <span
                                        class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                    تغییر به سفارش ناموفق
                                </div>
                            </a>
                        @endif
                        @if($order->payment_status == 0)
                            <a class="group relative inline-block px-1"
                               href="{{route('master.order.change.to.registered' , ['order' => $order->id ])}}">
                                <svg class="w-7 h-7">
                                    <use href="#registered"></use>
                                </svg>
                                <div
                                    class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                    <span
                                        class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                    تغییر به سفارش موفق
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="body p-4 py-9">

                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">نام و نام خانوادگی:</label>
                            <input type="text" disabled value="{{$order->user->name}} {{$order->user->family}}">
                        </div>
                        <div class="col-2">
                            <label class="form-label">شماره تماس:</label>
                            <input type="text" disabled value="{{$order->user->mobile}}">
                        </div>
                        <div class="col-2">
                            <label class="form-label">مبلغ:</label>
                            <input type="text" disabled value="{{number_format($order->total_amount)}}">
                        </div>
                        <div class="col-2">
                            <label class="form-label">مبلغ پرداختی:</label>
                            <input type="text" disabled value="{{number_format($order->paying_amount)}}">
                        </div>
                        <div class="col-2">
                            <label class="form-label">کدتخفیف:</label>
                            <input type="text" disabled
                                   value="{{ $order->coupon_id == null ? 'استفاده نشده' : $order->coupon->name }}">
                        </div>
                        <div class="col-2">
                            <label class="form-label"> مبلغ کد تخفیف:</label>
                            <input type="text" disabled value="{{ number_format($order->coupon_amount) }}">
                        </div>
                        <div class="col-8">
                            <label class="form-label">آدرس:</label>
                            <input type="text" disabled
                                   value="{{ $order->address->province->name }}  {{ $order->address->city->name }}  {{ $order->address->address }}">
                        </div>
                        <div class="col-2">
                            <label class="form-label">درگاه:</label>
                            <input type="text" disabled
                                   value="@if($order->payment == 'snapppay') اسنپ‌پی @else آنلاین @endif">
                        </div>
                        <div class="col-2">
                            <label class="form-label">تاریخ سفارش:</label>
                            <input type="text" disabled value="{{ verta($order->created_at) }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">یادداشت سفارش:</label>
                            <div disabled
                                 style="height: 150px!important; border: 1px solid #dce1e4;padding:10px;line-height: 1.5 !important;font-size:14px;color: #495057 !important;">{{ $order->note }}</div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="widget bg-white dark:bg-zinc-500  mx-auto">
                    <div class="body p-4">
                        <div>
                            <table class="w-full mx-auto table-auto text-center border-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>تصویر</th>
                                    <th>محصول</th>
                                    <th>مقدار</th>
                                    <th>فی</th>
                                    <th>تعداد</th>
                                    <th>مجموع</th>
                                    <th>بیشتر</th>
                                </tr>
                                </thead>
                                <tbody id="myTable">
                                @php($counter = 0)
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{++$counter}}</td>
                                        <td><a href="/product/{{$item->product->slug}}" target="_blank"><img
                                                    src="/images/product/{{$item->product->image}}"
                                                    alt="{{$item->product->name}}" width="70px"></a></td>
                                        <td><a href="/product/{{$item->product->slug}}"
                                               target="_blank">{{$item->product->name}}</a></td>
                                        <td>{{ \App\Models\ProductVariation::find($item->product_variation_id)->value }}</td>
                                        <td>{{ number_format($item->price) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->subtotal) }}</td>
                                        <td>
                                            @if($item->status == 0)
                                                <span>مرجوع شده</span>
                                            @else
                                                <a
                                                    class="group relative inline-block px-1" data-toggle="modal"
                                                    data-target="#exampleModal-{{$item->id}}">
                                                    <svg class="w-4 h-4">
                                                        <use href="#product"></use>
                                                    </svg>
                                                    <div
                                                        class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                                        <span
                                                            class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                                        تغییرتعداد
                                                    </div>
                                                </a>
                                                <a onclick="changeItemStatus({{$item->id}})"
                                                   class="group relative inline-block px-1" href="#">
                                                    <svg class="w-4 h-4">
                                                        <use href="#returned"></use>
                                                    </svg>
                                                    <div
                                                        class="bg-gray-950 transition-all  absolute left-1/2 z-20 -bottom-[38px] -translate-x-1/2 whitespace-nowrap rounded-[5px] py-1.5 px-3.5 text-sm text-white opacity-0 group-hover:opacity-100">
                                                        <span
                                                            class="bg-gray-950  absolute top-[-3px] left-1/2 -z-10 h-2 w-2 -translate-x-1/2 rotate-45"></span>
                                                        ثبت مرجوعی
                                                    </div>
                                                </a>
                                            @endif

                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModal-{{$item->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel-{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form>
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تغییر
                                                            تعداد {{$item->product->name}}</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="">
                                                            <label for="quantity" class="form-label">تعداد</label>
                                                            <input id="quantity" class="form-control" name="quantity"
                                                                   id="quantity" type="number"
                                                                   value="{{$item->quantity}}">
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-warning"
                                                                data-dismiss="modal">
                                                            لغو
                                                        </button>
                                                        <button type="button" class="btn btn-success" onclick="confirmUpdate()">ذخیره</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($order != 'failed')
                            <div class="" style="display: flex;justify-content: left">
                                <div class="col-md-2">
                                    <label style="color: transparent">f</label>
                                    <button class="btn btn-warning form-control" style="width: 100%;"
                                            onclick="confirmCancel()">
                                        لغو سفارش
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <br><br>
                <div class="footer flex justify-between items-center border-t border-gray-200 py-8 px-10">
                    @if($order->payment_status == 1)
                        <form action="{{route('master.order.send.code' , ['order' => $order->id])}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row flex">
                                <div class="col-md-7 ">
                                    <label>کد مرسوله:</label>
                                    <input class="form-control" style="width: 100%" type="text"
                                           value="{{ $order->code }}" name="code" {{$order->code ? 'disabled' : ''}} >
                                </div>
                                @if($order->code == null)
                                    <div class="col-md-5">
                                        <label style="color: transparent">f</label>
                                        <button class="btn btn-success form-control" style="width: 100%" type="submit">
                                            ارسال پیامک
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>



@endsection
@section('script')
    <script>
        function confirmCancel() {
            Swal.fire({
                title: "از مرجوع کردن سفارش مطمئن هستید ؟ ",
                showDenyButton: true,
                confirmButtonText: "بله",
                denyButtonText: `خیر`,
                showLoaderOnConfirm: true,
                backdrop: true,
                preConfirm: async () => {
                    try {

                        fetch("{{ route('master.order.change.status.snapp' , ['order' => $order->id ])}}", {
                            method: "GET",
                        })
                            .then(function (response) {
                                console.log(response)
                                if (response.status != 200) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطا در عملیات',
                                        // text: 'عملیات با خطا روبرو شده است',
                                    });
                                } else if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'عملیات موفق',
                                        text: 'سبد خرید با موفقیت مرجوع شد',
                                    });
                                    setInterval(() => {
                                        window.location.reload()
                                    }, 2000);
                                }

                            })
                            .catch(function (error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا در عملیات',
                                    text: 'عملیات با خطا روبرو شده است',
                                });
                            });

                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا در عملیات',
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading(),
            });
        }

        function confirmUpdate() {
            Swal.fire({
                title: "از تغییر دادن سفارش مطمئن هستید ؟ ",
                showDenyButton: true,
                confirmButtonText: "بله",
                denyButtonText: `خیر`,
                showLoaderOnConfirm: true,
                backdrop: true,
                preConfirm: async () => {
                    try {
                        let data = new FormData();
                        data.append('item_id', {{$item->id}})
                        data.append('_token', $('meta[name="_token"]').attr('content'))
                        data.append('quantity', document.getElementById('quantity').value)
                        fetch("{{ route('master.order.change.item.quantity')}}", {
                            method: "POST",
                            body: data
                        })
                            .then(function (response) {
                                console.log(response)
                                if (response.status != 200) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطا در عملیات',
                                        // text: 'عملیات با خطا روبرو شده است',
                                    });
                                } else if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'عملیات موفق',
                                        text: 'آیتم با موفقیت مرجوع شد',
                                    });
                                    setInterval(() => {
                                        window.location.reload()
                                    }, 2000);
                                }

                            })
                            .catch(function (error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا در عملیات',
                                    text: 'عملیات با خطا روبرو شده است',
                                });
                            });

                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا در عملیات',
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading(),
            });
        }

        function changeItemStatus(itemId) {
            var url = "{{ route('master.order.change.item.status' , ['order' => ":id" ])}}"
            url = url.replace(':id', itemId);

            Swal.fire({
                title: "از مرجوع کردن این آیتم مطمئن هستید ؟ ",
                showDenyButton: true,
                confirmButtonText: "بله",
                denyButtonText: `خیر`,
                showLoaderOnConfirm: true,
                backdrop: true,
                preConfirm: async () => {
                    try {

                        fetch(url, {
                            method: "GET",
                        })
                            .then(function (response) {

                                if (response.status != 200) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'خطا در عملیات',
                                        // text: 'عملیات با خطا روبرو شده است',
                                    });
                                } else if (response.status == 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'عملیات موفق',
                                        text: 'آیتم با موفقیت مرجوع شد',
                                    });
                                    setInterval(() => {
                                        window.location.reload()
                                    }, 2000);
                                }

                            })
                            .catch(function (error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطا در عملیات',
                                    text: 'عملیات با خطا روبرو شده است',
                                });
                            });

                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطا در عملیات',
                        });
                    }
                },
                allowOutsideClick: () => !Swal.isLoading(),
            });
        }
    </script>
@endsection
