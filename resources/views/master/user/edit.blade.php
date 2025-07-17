@extends('layout.master')
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                        ویرایش {{$user->name}} {{$user->family}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#user"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.user.update' , ['user' => $user->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>نام</label>
                                <input type="text" name="name" value="{{$user->name}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>نام خانوادگی</label>
                                <input type="text" name="family" value="{{$user->family}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>نقش کاربر</label>
                                <select name="role" id="">
                                    <option value="" selected>-</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->display_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="{{$user->mobile}}" name="mobile">
                        </div>

                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">

                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">ذخیره</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
@endsection
