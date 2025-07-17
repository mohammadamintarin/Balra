@extends('layout.profile')
@section('content')
<section class="search mt-10 font-peyda mb-20">
    <div class="container overflow-y-hidden relative h-full flex justify-between items-center md:min-h-screen text-navy-100">
        <div class="flex flex-wrap justify-center mx-auto">
            <div class="mt-28">
                <form action="{{route('profile.profile.update' , ['user' => auth()->user()->id])}}" method="POST" id="form-image" enctype="multipart/form-data">
                    @csrf
                    <div class="mx-auto">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type="file" name="avatar" id="imageUpload" accept=".png, .jpg, .jpeg , .webp">
                                <label for="imageUpload">
                                    <svg class="w-7 h-7 text-navy-100"><use xlink:href="#camera"></use></svg>
                                </label>
                            </div>
                            <div class="avatar-preview">
                                <img class="profile-user-img rounded-full mx-auto mb-3" id="imagePreview" style="width: 300px;height: 300px"
                                     src="{{ auth()->user()->avatar != null ?  auth()->user()->avatar : '/home/image/avatar.png' }}" alt="تصویر پروفایل">
                            </div>
                        </div>
                        <div>
                            <p class="text-lg text-center mb-7"> نام و تصویر شما در بخش نظرات دیده خواهد شد</p>
                        </div>
                        نام
                        <input type="text" class="h-14 mb-7 w-full px-3" placeholder="نام" name="name"
                               value="{{auth()->user()->name ? auth()->user()->name : ' '}}"
                            {{auth()->user()->name ? 'disabled' : ' '}} >
                        نام خانوادگی
                        <input type="text" class="h-14 mb-7 w-full px-3" placeholder="نام خانوادگی" name="family"
                               value="{{auth()->user()->family ?  auth()->user()->family   : ' '}}"
                            {{auth()->user()->family ? 'disabled' : ' '}} >
                        <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                         ویرایش و آپلود تصویر
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
