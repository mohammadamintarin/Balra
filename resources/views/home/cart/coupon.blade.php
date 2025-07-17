
    <form action="{{ route('home.coupon.check') }}" method="POST">
        @csrf
    <div class="flex justify-between mt-6 mb-6">
        <input type="text" name="code" class="w-full text-xs border-0 px-3.5 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400" placeholder="کد تخفیف خود را وارد کنید">
        <button class="bg-blue-500 text-xs px-3.5 py-2.5 text-white shadow-sm hover:bg-blue-600" type="submit">ثبت</button>

    </div>
    </form>