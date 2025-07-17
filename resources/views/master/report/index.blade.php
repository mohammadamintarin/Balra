@extends('layout.master')
@section('title')
    گزارش و نمودار
@endsection
@section('content')

    <div class="widget bg-white shadow dark:bg-zinc-500  mx-auto dark:bg-zinc-700 dark:text-white">
        <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
            <div class="text-2xl">
                گزارش
            </div>
            <div>
                <svg class="w-7 h-7"><use href="#chart"></use></svg>
            </div>
        </div>
        <div class="body p-4 py-9">
            <div class="row mt-8 mb-6">
                @include('master.report.product')
                @include('master.report.order')
                @include('master.report.province')
            </div>


            <hr>
            <div class="row mt-8 mb-6">
                @include('master.report.transactionStatus')
                @include('master.report.transactionGateway')
                @include('master.report.registerUser')
            </div>
            <hr>
            <div class="row mt-8 mb-6">
                @include('master.report.category')
                @include('master.report.order')
                @include('master.report.province')
            </div>
            <hr>
            <div  class="row mt-8">
                @include('master.report.transactionPerMonth')
            </div>



        </div>
    </div>




@endsection
@section('script')
    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>


{{--    <!-- jQuery Script -->--}}
{{--    <script type="text/javascript">--}}
{{--        var i = 0;--}}
{{--        function makeProgress(){--}}
{{--            var index = 0;--}}
{{--            $(".progress-bar-"+index).each(function() {--}}
{{--                var index = index +1;--}}
{{--                console.log($(".progress-bar").data('perc'));--}}
{{--            });--}}

{{--            if(i < 100){--}}
{{--                i = i + 1;--}}
{{--                let perc= $(".progress-bar").data('perc')--}}
{{--                $(".progress-bar").css("width", i + "%").text(perc);--}}
{{--            }--}}
{{--            // Wait for sometime before running this script again--}}
{{--            setTimeout("makeProgress()", 300);--}}
{{--        }--}}
{{--        makeProgress();--}}
{{--    </script>--}}








@endsection
