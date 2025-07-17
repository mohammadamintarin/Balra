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
                        تصاویر
                        {{$product->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#photo"></use></svg>
                    </div>
                </div>

                    <div class="body p-4 py-9 ">
                        @include('master.section.error')
                        <div class="container">

                            <div class="mt-8 mb-6 ">
                                <h2 id="variationName" style="font-weight: bold;font-size: 20px; padding: 0!important; margin-bottom: 20px">تصویر شاخص:</h2>
                                <div class="row">
                                    <div class="col-md-2 card">
                                        <img src="{{ url('images/product') . '/' . $product->image}}" class="img-fluid" alt="{{$product->name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mt-8 mb-6 ">
                                    <h2 id="variationName" style="font-weight: bold;font-size: 20px; padding: 0!important; margin-bottom: 20px">گالری محصول:</h2>
                                    <div class="row">
                                        @foreach($images as $item)
                                            <div class="col-md-2 text-center card mx-3 py-1">
                                                <img src="{{ url('images/product/gallery') . '/' . $item->image}}" class="img-fluid" alt="{{$product->name}}" >
                                                <div class="">
                                                    <form action="{{route('master.product.image.destroy', ['product' => $product->id])}}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="image_id" value="{{$item->id}}">
                                                        <button class="btn-sm btn-danger" type="submit" style="background-color: #dc3545;">حذف</button>
                                                    </form>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <form action="{{route('master.product.image.add' , ['product' => $product->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                            <div class="upload flex gap-x-2">
                                <div>
                                    <label for="myfile">تصویر شاخص:</label>
                                    <input type="file" id="myfile" name="image">
                                </div>
                                <div>
                                    <label for="images">تصاویر گالری:</label>
                                    <input type="file" id="images" multiple name="images[]">
                                </div>
                            </div>
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
