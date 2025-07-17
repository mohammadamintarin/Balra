<div class="col-md-4 mt-3">
    <h2 class="text-xl mb-3 text-gray-800"><span class="text-2xl">👀</span> بازدید محصولات </h2>
    <table class="w-full mx-auto table-auto text-center  h-2" style="border: 1px solid #eee;">
        <thead>
        <tr>
            <th>#</th>
            <th>نام</th>
            <th>تعداد</th>
        </tr>
        </thead>
        <tbody id="myTable" class=" overflow-y-auto">
        @php($counter = 0)
        @foreach($products as $product)
            <tr>
                <td>{{++$counter}}</td>
                <td>{{\Illuminate\Support\Str::limit($product->name , 30)}}</td>
                <td>{{$product->viewed}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
