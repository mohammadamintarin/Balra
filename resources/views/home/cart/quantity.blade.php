
<form action="{{ route('home.cart.update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="flex justify-between mt-2 mb-2 ">
        <input type="number" name="quantity[{{ $item->id }}]" value="{{ $item->quantity }}" data-max="{{ $item->attributes->quantity }}"
               class="w-full text-xs border-0 px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" placeholder="تعداد را وارد کنید">
        <button class="bg-blue-500 text-xs px-3.5 py-2.5 text-white shadow-sm hover:bg-blue-600" type="submit">بروزرسانی</button>

    </div>
</form>
