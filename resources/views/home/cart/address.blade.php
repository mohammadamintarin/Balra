@if(count($addresses) == 0)
    <div class="flex mx-auto container p-6 w-full dark:bg-zinc-800 dark:text-white">
        <div class="mb-4 rounded-lg bg-white px-6 shadow-md w-full md:flex justify-between py-4 items-center">
            <p> ☹️ هنوز آدرسی برای تحویل سفارش  برای شما ثبت نشده است، در ابتدا آدرس خود را وارد کنید. ️</p>
            <button class="py-2 px-6 bg-blue-500 text-white rounded hover:bg-blue-700" onclick="toggleModal()">افزودن آدرس</button>
        </div>
    </div>
@else
    <div class="flex mx-auto container w-full  md:px-0">
        <div class="mb-4 rounded-lg bg-white p-6 shadow-md w-full md:flex justify-between items-center border dark:bg-zinc-800 dark:text-white">
            <div class="flex items-center">
                <img src="/home/image/icon/location.gif" alt="loaction" style="width: 60px">
                <select class="h-14 w-full px-3.5 bg-white cursor-pointer dark:bg-zinc-800" id="address-select">
                    @foreach ($addresses as $address)
                        <option value="{{ $address->id }}"> {{ $address->address }} </option>
                    @endforeach
                </select>
            </div>
            <div class="justify-center">
                <button class="py-2 px-6 bg-blue-500 text-white rounded hover:bg-blue-700" onclick="toggleModal()">افزودن آدرس جدید</button>
            </div>
        </div>
    </div>
@endif



