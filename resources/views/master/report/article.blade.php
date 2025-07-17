<div class="col-md-4 mt-3">
    <h2 class="text-xl mb-3 text-gray-800"><span class="text-2xl">📕</span> بازدید مقالات </h2>
    <table class="w-full mx-auto table-auto text-center border-none">
        <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>تعداد</th>
        </tr>
        </thead>
        <tbody id="myTable">
        @php($counter = 0)
        @foreach($articles as $item)
            <tr>
                <td>{{++$counter}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->viewed}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
