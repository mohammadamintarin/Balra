@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                       ایجاد سفارش
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#products"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.order.store')}}" method="post">
                    @csrf
                    <div class="body p-4 py-9">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">نام و نام  خانوادگی:</label>
                                <select name="user_id" class="user-select selectpicker" data-live-search="true">
                                    <option value="null" selected>-</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}} {{$user->family}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-2">
                                <label class="form-label">آدرس:</label>
                                <select name="address_id" class="address-select"></select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">کدتخفیف:</label>
                                <input type="text"  value="">
                            </div>
                            <div class="col-2">
                                <label class="form-label"> مبلغ کد تخفیف:</label>
                                <input type="text"  value="">
                            </div>
                            <div class="col-2">
                                <label class="form-label">مبلغ سفارش:</label>
                                <input type="text"  value="">
                            </div>
                            <div class="col-2">
                                <label class="form-label">مبلغ پرداختی:</label>
                                <input type="text"  value="">
                            </div>
                            <div class="col-8">
                                <label class="form-label">محصولات:</label>
                                <select name="product_ids[]" class="user-select selectpicker" data-live-search="true" multiple>
                                    <option value="null">-</option>
                                    @foreach($products as $product)
                                        @foreach($product->variations()->where('product_id' , $product->id)->get()  as $variation)
                                            <option value="{{$product->id}}">{{$product->name}} مقدار:    {{$variation->value}}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">درگاه:</label>
                                <input type="text" value="نقدی">
                            </div>
                            <div class="col-2">
                                <label class="form-label">تاریخ سفارش:</label>
                                <input type="text"  value="{{verta(\Carbon\Carbon::now())->format('d M y')}}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">یادداشت سفارش:</label>
                                <input type="text" name="note"  style="height: 150px!important; border: 1px solid #dce1e4;padding:10px;line-height: 1.5 !important;font-size:14px;color: #495057 !important;" >
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="footer flex justify-between items-center border-t border-gray-200 py-8 px-10">
                        <button class="btn btn-success" type="submit">ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $('.user-select').change(function() {
            var userID = $(this).val();
            if (userID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-user-address-list') }}?user_id=" + userID,
                    success: function(res) {
                        if (res) {
                            $(".address-select").empty();
                            $.each(res, function(key, address) {
                                $(".address-select").append('<option value="' + address.id + '">' +
                                    address.address + '</option>');
                            });
                        } else {
                            $(".address-select").empty();
                        }
                    }
                });
            } else {
                $(".address-select").empty();
            }
        });
    </script>
@endsection
