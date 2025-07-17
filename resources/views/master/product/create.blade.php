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
                        افزودن محصول جدید
                    </div>
                    <div>
                        <svg class="w-7 h-7">
                            <use href="#category"></use>
                        </svg>
                    </div>
                </div>
                <form action="{{route('master.product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="body p-4 py-9 ">
                        @include('master.section.error')
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>نام محصول</label>
                                    <input type="text" name="name" id="name" value="{{old('name')}}" required onkeyup="seo()">
                                </div>
                                <div class="col-md-4">
                                    <label>عنوان انگلیسی</label>
                                    <input type="text" name="en" value="{{old('en')}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label> شناسه</label>
                                    <input type="text" name="sku" value="{{old('sku')}}">
                                </div>

                                <div class="col-md-4">
                                    <label>عنوان سئو</label>
                                    <input type="text" name="title" id="title" value="{{old('title')}}" required >
                                </div>
                                <div class="col-md-4">
                                    <label>توضیحات سئو</label>
                                    <input type="text" name="description" id="description" value="{{old('description')}}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>لینک کنونیکال</label>
                                    <input type="text" name="canonical" value="{{old('canonical')}}" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label>لینک ویدئو</label>
                                    <input type="text" name="video" value="{{old('video')}}">
                                </div>
                                <div class="col-md-3">
                                    <label>هزینه ارسال</label>
                                    <input type="text" name="delivery" value="0">
                                </div>
                                <div class="col-md-3">
                                    <label for="offer"> شگفت‌انگیز</label>
                                    <select name="offer" id="offer">
                                        <option value="0" selected>غیرفعال</option>
                                        <option value="1">فعال</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="best">پرفروش</label>
                                    <select name="best" id="best">
                                        <option value="0" selected>غیرفعال</option>
                                        <option value="1">فعال</option>
                                    </select>
                                </div>
                                <div class="w-full mb-6 col-md-12">
                                    <label class="block">محتوا</label>
                                    <textarea id="editor" name="contents">{{old('content')}}</textarea>
                                </div>
                                <div class="mb-6 row col-md-12">
                                    <div class="col-md-3">
                                        <label for="attribute">برند</label>
                                        <select class="selectpicker" data-live-search="true" id="brandSelect"
                                                name="brand_id">
                                            @foreach($brands as $brand )
                                                <option value="{{$brand->id}}"> {{$brand->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="attribute">مدل</label>
                                        <select class="selectpicker" id="typesSelect" name="type_id"></select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter">تگ</label>
                                        <select class="selectpicker" id="tagSelect" data-live-search="true" multiple
                                                name="tag_ids[]">
                                            @foreach($tags as $tag )
                                                <option value="{{$tag->id}}"> {{$tag->name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>دسته‌بندی</label>
                                        <select class="selectpicker" data-live-search="true" id="categorySelect"
                                                name="category_id">
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category->id}}">{{$category->parent->name . ' • ' }}{{ $category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="attributesContainer" class="mt-8 row">

                                    </div>

                                    <div class="mt-8 mb-6 col-md-12">
                                        <h2 id="variationName"
                                            style="font-weight: bold; color: red;font-size: 20px"></h2>
                                        <div id="czContainer">
                                            <div id="first">

                                                <div class="recordset">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>نام</label>
                                                            <input type="text" id="value" class="form-control variation"
                                                                   name="variation_values[value][]"/>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>قیمت</label>
                                                            <input type="text" id="value" class="form-control price"
                                                                   name="variation_values[price][]"/>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>تعداد</label>
                                                            <input type="text" id="value" class="form-control quantity"
                                                                   name="variation_values[quantity][]"/>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="flex gap-x-3 items-center">
                                    <div>
                                        <input type="text" class="form-control" id="price" placeholder="قیمت"
                                               style="margin-bottom: 0!important;">
                                    </div>
                                    <div>
                                        <button class="btn btn- btn-info" type="button" onClick="addVariation()">تغییر
                                            قیمت
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn- btn-warning" type="button" onClick="outOfStock()">
                                            ناموجود
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                            <div class="upload flex gap-x-2">
                                <div>
                                    <label for="myfile">تصویر شاخص:</label>
                                    <input type="file" id="myfile" name="file">
                                </div>
                                <div>
                                    <label for="images">تصاویر گالری:</label>
                                    <input type="file" id="images" multiple name="images[]">
                                </div>
                                <div>
                                    <label for="cover">تصویر ویدئو:</label>
                                    <input type="file" id="cover" name="cover">
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
@section('script')
    @include('master.section.editor')
    @include('master.product.type')
    <script src="/admin/js/jquery.czMore.js"></script>
    <script>
        $('#attributeContainer').hide();
        $('#czContainer').czMore();
        $('#btnPlus').click(function () {

        });
        for (i = 0; i > 8; i++) {
            $('#czContainer').czMore();
        }

        $('#categorySelect').on('changed.bs.select', function () {
            var categoryId = $(this).val();
            $.get(`{{ url('/master/category-attributes/${categoryId}') }}`,
                function (response, status) {
                    if (status == 'success') {
                        $('#attributesContainer').find('input.att').remove();
                        $('#attributesContainer').find('label.att').remove();
                        $('#attributesContainer').find('div.att').remove();
                        $('#attributeContainer').fadeIn();
                        var values= ['سوزنی' ,' ' ,'آستین بلند' ,'سلامت کالا' ,'چهار فصل' ,'آقایان و بانوان' ,'آنتی باکتریال، قابلیت گردش هوا'];
                        if(categoryId == 8){
                            var values= ['اسپندکس' ,'نیور' ,'تمام‌کش' ,'سلامت کالا' ,'آنتی باکتریال، قابلیت گردش هوا'];
                        }
                        i = 0;
                        response.attributes.forEach(attribute => {
                            let attributeFormGroup = $('<div/>', {
                                class: 'col-md-3 att'
                            });
                            attributeFormGroup.append($('<label/>', {
                                text: attribute.name,
                                class: 'att',
                            }));
                            attributeFormGroup.append($('<input/>', {
                                class: 'att',
                                type: 'text',
                                name: `attribute_ids[${attribute.id}]`,
                                value : values[i]
                            }));
                            console.log(values[i]);
                            i++;
                            $('#attributesContainer').append(attributeFormGroup);
                        });
                        $('#variationName').text("ایجاد  تنوع محصول بر اساس: " + response.variation.name);
                    } else {
                        alert('error');
                    }
                }).fail(function () {
                alert('error');
            })
        });

        function addVariation() {
            let value = $('#price').val();
            let price = $('.price');
            let variation = $('.variation')
            let quantity = $('.quantity');
            let categoryId = $('#categorySelect').val();
            price.val(value);
            quantity.val(10000);

            var sizes = ["M", "L", "XL", "2XL", "3XL", "4XL"];
            if(categoryId == 8){
                var sizes = ["S", "M", "L", "XL", "2XL", "3XL", "4XL", "5XL"];
            }
            variation.each(function (i, e) {
                if ($(e).val() == "") {
                    $(e).val(sizes[i]);
                }
            })
        }

        function outOfStock() {
            let quantity = $('.quantity');
            k = 0;
            quantity.each(function (i, e) {
                $(e).val(0);
                k++;
            });
        }

        function seo() {
            let x = document.getElementById("name");
            let title  = "قیمت و خرید " + x.value + " با ضمانت اصالت کالا";
            let description  = "قیمت و خرید " + x.value + " با ضمانت اصالت و سلامت کالا در فروشگاه نیور با ارسال رایگان به سراسر کشور";
            let titleInput = document.getElementById("title").value = title;
            let descriptionInput = document.getElementById("description").value = description;
        }


    </script>



@endsection
