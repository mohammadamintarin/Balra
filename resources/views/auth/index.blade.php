@extends('layout.auth')
@section('content')
    <form id="authForm">
        <div class="relative font-inter antialiased">
            <main class="relative min-h-screen flex flex-col justify-center bg-slate-50 overflow-hidden">
                <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24">
                    <div class="flex justify-center">
                        <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
                            <header class="mb-8">
                                <h1 class="text-2xl font-bold mb-1">ورود به سایت</h1>
                                <p class="text-[15px] text-slate-500">شماره موبایل خود را وارد  کنید</p>
                            </header>
                            <div class="flex items-center justify-center gap-3">
                                <input
                                    id="mobileInput"
                                    type="tel"
                                    class="text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                                    pattern="\d*" maxlength="11" required/>

                            </div>
                            <div class="max-w-[260px] mx-auto mt-4">
                                <button type="submit"class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">
                                    ارسال کد تایید
                                </button>
                            </div>
                            <div  id="resendOTPButton" class="text-sm text-slate-500 mt-4"><a class="font-medium text-indigo-500 hover:text-indigo-600" href="#0">ارسال دوباره</a> کدی  دریافت نکردید؟ </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </form>


    <form id="checkOTpForm">
        <div class="relative font-inter antialiased">
            <main class="relative min-h-screen flex flex-col justify-center bg-slate-50 overflow-hidden">
                <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-24">
                    <div class="flex justify-center">
                        <div class="max-w-md mx-auto text-center bg-white px-4 sm:px-8 py-10 rounded-xl shadow">
                            <header class="mb-8">
                                <h1 class="text-2xl font-bold mb-1">ورود به سایت</h1>
                                <p class="text-[15px] text-slate-500">کد ۴ رقمی پیامک شده را وارد نمایید</p>
                            </header>
                            <div class="flex items-center justify-center gap-3">
                                <input
                                    id="OTPInput" type="number"
                                    class="text-center text-2xl font-extrabold text-slate-900 bg-slate-100 border border-transparent hover:border-slate-200 appearance-none rounded p-4 outline-none focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"
                                    pattern="\d*" maxlength="4" required/>

                            </div>
                            <div class="max-w-[260px] mx-auto mt-4">
                                <button type="submit"class="w-full inline-flex justify-center whitespace-nowrap rounded-lg bg-indigo-500 px-3.5 py-2.5 text-sm font-medium text-white shadow-sm shadow-indigo-950/10 hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-300 focus-visible:outline-none focus-visible:ring focus-visible:ring-indigo-300 transition-colors duration-150">
                                   ورود
                                </button>
                            </div>
                            <span id="resendOTPTime" class="fl"></span>
                            <div  id="resendOTPButton" class="text-sm text-slate-500 mt-4">کدی دریافت نکردید؟ <button type="submit" class="font-medium text-indigo-500 hover:text-indigo-600">ارسال دوباره</button></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </form>
@endsection
@section('script')
    <script>
        let loginToken;
        function timer() {
            let e = "1:01",
                n = setInterval(function () {
                    let t = e.split(":"),
                        o = parseInt(t[0], 10),
                        i = parseInt(t[1], 10);
                    --i, (o = i < 0 ? --o : o), o < 0 && (clearInterval(n), $("#resendOTPTime").hide(), $("#resendOTPButton").fadeIn()), (i = i < 0 ? 59 : i), (i = i < 10 ? "0" + i : i), $("#resendOTPTime").html(o + ":" + i), (e = o + ":" + i);
                }, 1e3);
        }
        $("#checkOTpForm").hide(),
        $("#resendOTPButton").hide(),

            $("#authForm").submit(function (e) {
                e.preventDefault(),
                    $.post(
                        "{{url('/auth')}}",
                        { _token: "{{csrf_token()}}", mobile: $("#mobileInput").val() },
                        function (e, n) {
                            (loginToken = e.token),
                            $("#authForm").fadeOut(),
                            $("#checkOTpForm").fadeIn(),

                            timer();
                    }).fail(function (e) {});
            }),
            $("#checkOTpForm").submit(function (e) {
                e.preventDefault(),
                    $.post("{{url('/otp')}}", { _token: "{{csrf_token()}}", otp: $("#OTPInput").val(), token: loginToken }, function (e, n) {
                        console.log(e, n), $(location).attr("href", "{{url()->previous()}}");
                    }).fail(function (e) {});
            }),
            $("#resendOTPButton").click(function (e) {
                e.preventDefault(),
                    $.post("{{ url('/resend') }}", { _token: "{{ csrf_token() }}", token: loginToken }, function (e, n) {
                        (loginToken = e.token), $("#resendOTPButton").fadeOut(), timer(), $("#resendOTPTime").fadeIn();
                    }).fail(function (e) {});
            });
    </script>
@endsection
