<div class="col-md-4 mt-3">
    <h2 class="text-xl mb-3 text-gray-800"><span class="text-2xl">📦</span> فروش محصولات </h2>
    <table class="w-full mx-auto table-auto text-center border-none " style="border: 1px solid #eee;">
        <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>تعداد</th>
        </tr>
        </thead>
        <tbody id="myTable"  style="overflow-y:auto; height:200px;">
        @php($counter = 0)
        @foreach($orders as $order)
            <tr>
                <td>{{++$counter}}</td>
                <td>{{\Illuminate\Support\Str::limit($order->name , 30)}}</td>
                <td>{{$order->orders_count}}</td>
            </tr>


        @endforeach
{{--        <tr>--}}
{{--            <div class="progress" style="height:15px;">--}}
{{--                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"--}}
{{--                     style="width:100%;max-width: 49%!important;"--}}
{{--                     role="progressbar"--}}
{{--                     aria-valuenow="90"--}}
{{--                     aria-valuemin="0"--}}
{{--                     aria-valuemax="100"--}}
{{--                     data-perc="2"--}}
{{--                >49</div>--}}

{{--            </div>--}}
{{--        </tr>--}}
        </tbody>
    </table>
</div>
