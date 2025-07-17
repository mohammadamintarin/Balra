@auth()

    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal" >
        <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-center bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form action="{{ route('profile.add.address') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{auth()->user()->mobile}}" name="mobile">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label class="font-medium text-gray-800">نام</label>
                        <input type="text" class="w-full outline-none rounded bg-gray-100 p-2  mt-2.5 mb-3" name="name" value="{{ old('name') }}"/>
                        @error('title', 'addressStore')
                        <p>
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                        <label class="font-medium text-gray-800">نام خانوادگی</label>
                        <input type="text" class="w-full outline-none rounded bg-gray-100 p-2  mt-2.5 mb-3" name="family" value="{{ old('family') }}"/>
                        <div class="flex justify-between  mt-2.5">
                            <div class="w-full">
                                <label class="font-medium text-gray-800 block">
                                    استان
                                </label>
                                <select class="block w-full  mt-2.5 ounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 province-select" name="province_id">
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full">
                                <label class="font-medium text-gray-800  block">
                                    شهر
                                </label>
                                <select class="block  mt-2.5 w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 city-select" name="city_id">
                                </select>
                            </div>
                        </div>

                        <div class=" mt-2.5">
                            <label class="font-medium text-gray-800">آدرس</label>
                            <input type="text" class="w-full outline-none rounded bg-gray-100 p-2 mt-2.5 mb-3"  type="text" name="address" value="{{ old('address') }}"/>
                            @error('address', 'addressStore')
                            <p>
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                    </div>
                    <div class="bg-gray-200 px-4 py-3 text-center">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="toggleModal()"></i> بستن</button>
                        <button  type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"></i> ذخیره</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endauth
