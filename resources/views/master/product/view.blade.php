@extends('layout.master')
@section('title')
    {{$product->title}}
@endsection
@section('content')

    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                     {{$product->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#category"></use></svg>
                    </div>
                </div>
                    <div class="body p-4 py-9 ">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>نام محصول</label>
                                    <input type="text" name="name" value="{{$product->name}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>عنوان انگلیسی</label>
                                    <input type="text" name="en" value="{{$product->en}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label> شناسه</label>
                                    <input type="text" name="sku" value="{{$product->sku}}" disabled>
                                </div>

                                <div class="col-md-4">
                                    <label>عنوان سئو</label>
                                    <input type="text" name="title" value="{{$product->title}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>توضیحات سئو</label>
                                    <input type="text" name="description" value="{{$product->description}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>لینک کنونیکال</label>
                                    <input type="text" name="canonical" value="{{$product->canonical}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>هزینه ارسال</label>
                                    <input type="text" name="delivery" value="{{$product->delivery}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="offer"> شگفت‌انگیز</label>
                                    <input type="text" name="delivery" value="{{$product->best}}" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="best">پرفروش</label>
                                    <input type="text" name="delivery" value="{{$product->offer}}" disabled>
                                </div>
                                <div class="w-full mb-6 col-md-12">
                                    <label class="block">محتوا</label>
                                    <textarea id="editor" name="contents" disabled>{!! $product->content !!}</textarea>
                                </div>
                                <div class="mb-6 row col-md-12">
                                    <div class="col-md-3">
                                        <label for="attribute">برند</label>
                                        <input type="text" value="{{$product->brand->name}}" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="attribute">مدل</label>
{{--                                        <input type="text" value="{{$product->type->name==null ? ' ' : $product->type->name}}" disabled>--}}
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter">تگ</label>
                                        <input type="text" value="@foreach($tags as $tag){{$tag->name}} @endforeach" disabled>
                                    </div>

                                    <div class="col-md-3">
                                        <label>دسته‌بندی</label>
                                        <input type="text" value="{{$product->category->name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-8 mb-6">
                                        <h2 id="variationName" style="font-weight: bold;font-size: 20px; padding: 0!important; margin-bottom: 20px">ویژگی‌:</h2>
                                        <div id="czContainer">
                                            <div id="first">
                                                <div class="recordset">
                                                    @foreach($product->attributes  as $attribute)
                                                        <div class="form-row">
                                                            <div class="form-group col-md-2">
                                                                <label>{{$attribute->attribute->name}}</label>
                                                                <input type="text" class="form-control" value="{{$attribute->value}}" disabled/>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-8 mb-6">
                                        <h2 id="variationName" style="font-weight: bold;font-size: 20px; padding: 0!important; margin-bottom: 20px">متغیر:</h2>
                                        <div id="czContainerc">
                                            <div id="firstc">
                                                <div class="recordset">
                                                    @foreach($variations  as $variation)
                                                        <div class="form-row">
                                                            <div class="form-group col-md-2">
                                                                <label>نام</label>
                                                                <input type="text" class="form-control" value="{{$variation->value}}" disabled/>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>قیمت</label>
                                                                <input type="text" class="form-control" value="{{$variation->price}}" disabled/>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>موجودی</label>
                                                                <input type="text" class="form-control" value="{{$variation->quantity}}" disabled/>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>شگفت انگیز</label>
                                                                <input type="text" class="form-control" value="{{$variation->sale_price == null ? '-' : $variation->sale_price}}" disabled/>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>تاریخ شروع</label>
                                                                <input type="text" class="form-control" value="{{$variation->date_on_sale_from == null ? '-'  : verta($variation->date_on_sale_from)}}" disabled/>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label>تاریخ پایان</label>
                                                                <input type="text" class="form-control" value="{{$variation->date_on_sale_to == null ? '-' : verta($variation->date_on_sale_to)}}" disabled/>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8 mb-6 ">
                                        <h2 id="variationName" style="font-weight: bold;font-size: 20px; padding: 0!important; margin-bottom: 20px">تصاویر:</h2>
                                       <div class="row">
                                           <div class="col-md-2">
                                               <img src="{{ url('images/product/image') . '/' . $product->image}}" class="img-fluid" alt="{{$product->name}}" width="200px">
                                           </div>
                                            @foreach($images as $item)
                                               <div class="col-md-2">
                                                   <img src="{{ url('images/product/gallery') . '/' . $item->image}}" class="img-fluid" alt="{{$product->name}}" width="200px">
                                               </div>
                                            @endforeach
                                        </div>
                                   </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @include('master.section.editor')
@endsection
