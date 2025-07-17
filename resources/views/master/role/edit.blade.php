@extends('layout.master')
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                        افزودن نقش جدید
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#role"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.role.update' , ['role' => $role->id])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>نام مجوز</label>
                                <input type="text" name="name" value="{{$role->name}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>نام نمایشی مجوز</label>
                                <input type="text" name="display_name" value="{{$role->display_name}}" required>
                            </div>
                        </div>
                        <p class="mt-3">انتخاب سطح دسترسی</p>
                        @foreach($permissions as $permission)
                            <div class="flex align-content-center items-center">
                                <input id="permission_{{$permission->id}}" type="checkbox" value="{{$permission->name}}" style="width: 20px!important; margin: 5px 5px"
                                    {{ in_array( $permission->id , $role->permissions->pluck('id')->toArray() ) ? 'checked' : '' }}
                                >
                                <label for="permission_{{$permission->id}}">{{$permission->display_name}}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search"></div>
                        <div>
                            <button class="btn btn-success" type="submit">ذخیره</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
