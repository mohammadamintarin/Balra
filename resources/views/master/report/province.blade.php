<div class="col-md-4 mt-3">
    <h2 class="text-xl mb-3 text-gray-800">  <span class="text-2xl">🏡</span> فروش  استانی</h2>
    <table class="w-full mx-auto table-auto text-center border-none" style="border: 1px solid #eee;">
        <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>تعداد</th>
        </tr>
        </thead>
        <tbody id="myTable">
        @php($counter = 0)
        @foreach($provinces as $province)
            <tr>
                <td>{{++$counter}}</td>
                <td>{{$province->name}}</td>
                <td>{{$province->user_address_count}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
