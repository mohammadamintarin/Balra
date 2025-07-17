@extends('home.sections.master')

@section('title')
    صفحه ای سفارش
@endsection


@section('content')
    @include('home.sections.menu')

@if(count($addresses) == 0)
    <br>
    <br>
    <div class="container cart-empty-content mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <i class="sli sli-map"></i>
                <h2 class="font-weight-bold my-4">آدرسی برای شما ثبت نشده است.</h2>
                <p class="mb-40">لطفا یک آدرس برای تحویل سفارش وارد کنید.</p>
            </div>
        </div>
    </div>
<div class="container mt-5">
    <div class="col-lg-12">
        <div class="rtl">
            @include('master.sections.errors')
            <form action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="tax-select col-lg-3 col-md-3 rtl">
                        <label>
                            نام و نام خانوادگی
                        </label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}">
                        @error('title', 'addressStore')
                        <p class="input-error-validation">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                    <div class="tax-select col-lg-4 col-md-4">
                        <label>
                            استان
                        </label>
                        <select class="email s-email s-wid province-select form-control" name="province_id">
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}">{{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('province_id', 'addressStore')
                        <p class="input-error-validation">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                    <div class="tax-select col-lg-4 col-md-4">
                        <label>
                            شهر
                        </label>
                        <select class="email s-email s-wid city-select form-control" name="city_id">
                        </select>
                        @error('city_id', 'addressStore')
                        <p class="input-error-validation">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                    <div class="tax-select col-lg-12 col-md-12">
                        <label>
                            آدرس
                        </label>
                        <input class="form-control" type="text" name="address" value="{{ old('address') }}">
                        @error('address', 'addressStore')
                        <p class="input-error-validation">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>

                    <div class=" col-lg-12 col-md-12 ltr">
                        <button class="cart-btn-2 btn btn-success" type="submit"> ثبت آدرس</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <br><br><br>
@else
    <div class="checkout-main-area pt-70 pb-70 text-right" style="direction: rtl;">
        <div class="container">
            <div class="checkout-wrap pt-30">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="billing-info-wrap mr-50">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="billing-info tax-select mb-20">
                                        <label> انتخاب آدرس  <abbr class="required" title="required">*</abbr></label>

                                        <select class="email s-email s-wid" id="address-select">
                                            @foreach ($addresses as $address)
                                                <option value="{{ $address->id }}"> {{ $address->address }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="collapse-address-create-content"
                                         style="{{ count($errors->addressStore) > 0 ? 'display:block' : '' }}">
                                    @include('master.sections.errors')
                                        <form action="{{ route('profile.addresses.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="tax-select col-lg-3 col-md-3 rtl">
                                                    <label>
                                                        نام و نام خانوادگی
                                                    </label>
                                                    <input class="form-control" type="text" name="title" value="{{ old('title') }}">
                                                    @error('title', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        استان
                                                    </label>
                                                    <select class="form-control province-select" name="province_id">
                                                        @foreach ($provinces as $province)
                                                            <option value="{{ $province->id }}">{{ $province->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('province_id', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-6 col-md-6">
                                                    <label>
                                                        شهر
                                                    </label>
                                                    <select class="form-control city-select" name="city_id">
                                                    </select>
                                                    @error('city_id', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="tax-select col-lg-12 col-md-12">
                                                    <label>
                                                        آدرس
                                                    </label>
                                                    <input  class="form-control"  type="text" name="address" value="{{ old('address') }}">
                                                    @error('address', 'addressStore')
                                                    <p class="input-error-validation">
                                                        <strong>{{ $message }}</strong>
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class=" col-lg-12 col-md-12">

                                                    <button class="cart-btn-2" type="submit"> ثبت آدرس
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <form action="{{route('home.payment')}}" method="POST">
                            @csrf
                            <input type="hidden" id="address-input" name="address_id">
                            <div class="your-order-area">
                                <h3> سفارش شما </h3>
                                <div class="your-order-wrap gray-bg-4">
                                    <div class="your-order-info-wrap">
                                        <div class="your-order-info">
                                            <ul>
                                                <li> محصول <span> جمع </span></li>
                                            </ul>
                                        </div>
                                        <div class="your-order-middle">
                                            <ul>
                                                @foreach (\Cart::getContent() as $item)
                                                    <li class="d-flex justify-content-between">
                                                        <div>
                                                            {{ $item->name }}
                                                            -
                                                            {{ $item->quantity }}
                                                            <p class="mb-0" style="font-size: 12px; color:red">
                                                                {{ \App\Models\Attribute::find($item->attributes->attribute_id)->name }}
                                                                :
                                                                {{ $item->attributes->value }}
                                                            </p>
                                                        </div>
                                                        <span>
                                                        {{ number_format($item->price) }}
                                                        تومان
                                                        @if ($item->attributes->is_sale)
                                                                <p style="font-size: 12px ; color:red">
                                                                {{ $item->attributes->percent_sale }}%
                                                                تخفیف
                                                            </p>
                                                            @endif
                                                    </span>

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-subtotal">
                                            <ul>
                                                <li> مبلغ
                                                    <span>
                                                    {{ number_format(\Cart::getTotal() + cartTotalSaleAmount()) }}
                                                    تومان
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                        @if (cartTotalSaleAmount() > 0)
                                            <div class="your-order-info order-subtotal">
                                                <ul>
                                                    <li>
                                                        مبلغ تخفیف کالا ها :
                                                        <span style="color: red">
                                                        {{ number_format(cartTotalSaleAmount()) }}
                                                        تومان
                                                    </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                        @if (session()->has('coupon'))
                                            <div class="your-order-info order-subtotal">
                                                <ul>
                                                    <li>
                                                        مبلغ کد تخفیف :
                                                        <span style="color: red">
                                                        {{ number_format(session()->get('coupon.amount')) }}
                                                        تومان
                                                    </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="your-order-info order-shipping">
                                            <ul>
                                                <li> هزینه ارسال
                                                    @if (cartTotalDeliveryAmount() == 0)
                                                        <span style="color: red">
                                                        رایگان
                                                    </span>
                                                    @else
                                                        <span>
                                                        {{ number_format(cartTotalDeliveryAmount()) }}
                                                        تومان
                                                    </span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="your-order-info order-total">
                                            <ul>
                                                <li>جمع کل
                                                    <span>
                                                    {{ number_format(cartTotalAmount()) }}
                                                    تومان </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="payment-method d-none" >
                                        <div class="pay-top sin-payment">
                                            <input id="zarinpal" class="input-radio" type="radio" value="zarinpal"
                                                   checked="checked" name="payment_method">
                                            <label for="zarinpal"> درگاه پرداخت زرین پال </label>
                                            <div class="payment-box payment_method_bacs">
                                                <p>
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                                    طراحان گرافیک است.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="pay-top sin-payment">
                                            <input id="pay" class="input-radio" type="radio" value="pay" name="payment_method">
                                            <label for="pay">درگاه پرداخت پی</label>
                                            <div class="payment-box payment_method_bacs">
                                                <p>
                                                    لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                                    طراحان گرافیک است.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Place-order mt-40">
                                    <button type="submit">ثبت سفارش</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@section('script')
    <script>
        $('.province-select').change(function() {

            var provinceID = $(this).val();

            if (provinceID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-province-cities-list') }}?province_id=" + provinceID,
                    success: function(res) {
                        if (res) {
                            $(".city-select").empty();

                            $.each(res, function(key, city) {
                                console.log(city);
                                $(".city-select").append('<option value="' + city.id + '">' +
                                    city.name + '</option>');
                            });

                        } else {
                            $(".city-select").empty();
                        }
                    }
                });
            } else {
                $(".city-select").empty();
            }
        });
        $('#address-input').val( $('#address-select').val() );
        $('#address-select').change(function() {
            $('#address-input').val($(this).val());
        });
    </script>
@endsection
