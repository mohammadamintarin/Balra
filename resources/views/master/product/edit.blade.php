@extends('layout.master')
@section('style')
    <link rel="stylesheet" href="/admin/css/mds.bs.datetimepicker.style.css">
@endsection
@section('title')
    {{$title}}
@endsection
@section('content')
    <section class="mb-52">
        <div class="container">
            <div class="bg-white shadow border border-gray-100 dark:bg-zinc-500 w-[90%] mx-auto data_more_less">
                <div class="header flex justify-between items-center border-b border-gray-200 p-5 px-10">
                    <div class="text-2xl">
                       ویرایش {{$product->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#category"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.product.update' , ['product' => $product->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="body p-4 py-9 ">
                        @include('master.section.error')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>نام محصول</label>
                                    <input type="text" name="name" value="{{$product->name}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>عنوان انگلیسی</label>
                                    <input type="text" name="en" value="{{$product->en}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label> شناسه</label>
                                    <input type="text" name="sku" value="{{$product->sku}}">
                                </div>

                                <div class="col-md-4">
                                    <label>عنوان سئو</label>
                                    <input type="text" name="title" value="{{$product->title}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>توضیحات سئو</label>
                                    <input type="text" name="description" value="{{$product->description}}">
                                </div>
                                <div class="col-md-4">
                                    <label>لینک کنونیکال</label>
                                    <input type="text" name="canonical" value="{{$product->canonical}}">
                                </div>
                                <div class="col-md-3">
                                    <label>لینک ویدئو</label>
                                    <input type="text" name="video" value="{{$product->video}}">
                                </div>
                                <div class="col-md-3">
                                    <label>هزینه ارسال</label>
                                    <input type="text" name="delivery" value="{{$product->delivery}}">
                                </div>
                                <div class="col-md-3">
                                    <label for="offer"> شگفت‌انگیز</label>
                                    <select name="offer" id="offer">
                                        <option value="0" {{$product->getRawOriginal('offer') ?  'selected' : " "}}>غیرفعال</option>
                                        <option value="1" {{$product->getRawOriginal('offer') ?  'selected' : " "}}>فعال</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="best">پرفروش</label>
                                    <select name="best" id="best">
                                        <option value="0" {{$product->getRawOriginal('best')? 'selected'  : " "}}>غیرفعال</option>
                                        <option value="1" {{$product->getRawOriginal('best') ?  'selected' : " "}}>فعال</option>
                                    </select>
                                </div>
                                <div class="w-full mb-6 col-md-12">
                                    <label class="block">محتوا</label>
                                    <textarea id="editor" name="contents">{!! $product->content !!}</textarea>
                                </div>
                                <div class="mb-6 row col-md-12">
                                    <div class="col-md-4">
                                        <label for="attribute">برند</label>
                                        <select class="selectpicker" data-live-search="true" id="brandSelect" name="brand_id">
                                            @foreach($brands as $brand )
                                                <option value="{{$brand->id}}" {{$product->brand_id == $brand->id ? 'selected'  : ' '}}> {{$brand->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="attribute">مدل</label>
                                        <select class="selectpicker" id="typesSelect" name="type_id">
                                            <option value="">...</option>
                                            @foreach($types as $type )
                                                <option value="{{$type->id}}" {{$product->type_id == $type->id ? 'selected'  : ' '}}> {{$type->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filter">تگ</label>
                                        <select class="selectpicker" id="tagSelect" data-live-search="true" multiple name="tag_ids[]" >
                                            @php
                                                $productTags = $product->tags()->pluck('id')->toArray()
                                            @endphp
                                            @foreach($tags as $tag )
                                                <option value="{{$tag->id}}" {{in_array($tag->id , $productTags) ? 'selected' : ' '}}> {{$tag->name}} </option>
                                            @endforeach
                                        </select>
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
                                                                <input type="text" class="form-control" value="{{$attribute->value}}" name="attribute_values[{{$attribute->id}}]"/>
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
                                                            <div class="form-group col-md-1">
                                                                <label>نام</label>
                                                                <input type="text" class="form-control" value="{{$variation->value}}" name="variation_values[{{$variation->id}}][value]"/>
                                                            </div>
                                                            <div class="form-group col-md-1">
                                                                <label>قیمت</label>
                                                                <input type="text" class="form-control" value="{{$variation->price}}" name="variation_values[{{$variation->id}}][price]"/>
                                                            </div>
                                                            <div class="form-group col-md-1">
                                                                <label>موجودی</label>
                                                                <input type="text" class="form-control" value="{{$variation->quantity}}" name="variation_values[{{$variation->id}}][quantity]"/>
                                                            </div>
                                                            <div class="form-group col-md-1">
                                                                <label>شگفت انگیز</label>
                                                                <input type="text" class="form-control" value="{{$variation->sale_price == null ? null : $variation->sale_price}}" name="variation_values[{{$variation->id}}][sale_price]"/>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>تاریخ شروع</label>
                                                                <div class="input-group flex">
                                                                    <div class="input-group-prepend order-2" style="height: 38px">
                                                                    <span class="input-group-text" id="variationDateOnSaleFrom-{{$variation->id}}">
                                                                        <svg class="w-4 h-4"><use href="#time"></use></svg>
                                                                    </span>
                                                                    </div>
                                                                    <div style="width: 85%">
                                                                        <input id="variationInputDateOnSaleFrom-{{$variation->id}}" type="text" class="form-control" name="variation_values[{{$variation->id}}][date_on_sale_from]" value="{{ $variation->date_on_sale_from == null ? null : verta($variation->date_on_sale_from) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-4">
                                                                <label>تاریخ پایان</label>
                                                                <div class="input-group flex">
                                                                    <div class="input-group-prepend order-2" style="height: 38px">
                                                                    <span class="input-group-text" id="variationDateOnSaleTo-{{$variation->id}}">
                                                                        <svg class="w-4 h-4"><use href="#time"></use></svg>
                                                                    </span>
                                                                    </div>
                                                                    <div style="width: 85%">
                                                                        <input id="variationInputDateOnSaleTo-{{$variation->id}}" type="text" class="form-control" name="variation_values[{{$variation->id}}][date_on_sale_to]" value="{{ $variation->date_on_sale_to == null ? null : verta($variation->date_on_sale_to) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                            <div>
                                <label for="cover">تصویر ویدئو:</label>
                                <input type="file" id="cover" name="cover">
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
@section('script')
    @include('master.section.editor')
    <script src="/admin/js/mds.bs.datetimepicker.js"></script>
    <script>
        let variations = @json($variations);
        variations.forEach(variation => {
            $(`#variationDateOnSaleFrom-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleFrom-${variation.id}`,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
                enableTimePicker: true,
                englishNumber: true
            });
            $(`#variationDateOnSaleTo-${variation.id}`).MdPersianDateTimePicker({
                targetTextSelector: `#variationInputDateOnSaleTo-${variation.id}`,
                textFormat: 'yyyy-MM-dd HH:mm:ss',
                enableTimePicker: true,
                englishNumber: true
            });
        });
    </script>
@endsection
