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
                        ویرایش آدرس‌های {{$user->name}} {{$user->family}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#user"></use></svg>
                    </div>
                </div>
                <form action="{{route('profile.add.address')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-2">
                                    <label>نام</label>
                                    <input class="form-control" type="text" id="address-fn" name="name" required="">
                                </div>
                                <div class="sm:col-span-2">
                                    <label>نام خانوادگی</label>
                                    <input class="form-control" type="text" id="address-ln" required="" name="family">
                                </div>
                                <div class="sm:col-span-2">
                                    <label>شماره موبایل</label>
                                    <input class="form-control" type="text" id="address-mobile" required="" name="mobile">
                                </div>
                                <div class="sm:col-span-2">
                                    <label>استان</label>
                                    <select class="province-select form-select" name="province_id" id="address-province" required="">
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}">
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label> شهر</label>
                                    <select class="city-select form-select" id="address-city"  name="city_id" required="">
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label>آدرس</label>
                                    <input class="form-control" type="text" id="address-line1" required="" name="address">
                                </div>
                        </div>

                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
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
    </script>
@endsection
