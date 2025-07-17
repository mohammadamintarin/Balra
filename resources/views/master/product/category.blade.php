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
                       ویرایش دسته‌بندی {{$product->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#category"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.product.category.update' , ['product' => $product->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="body p-4 py-9 ">
                        @include('master.section.error')
                        <div class="container">
                            <div class="row text-center">
                                <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <label>دسته‌بندی</label>
                                        <select class="selectpicker" data-live-search="true" id="categorySelect" name="category_id">
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->parent->name . ' • ' }}{{ $category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                <div class="col-md-4"></div>
                                </div>
                                <div class="col-md-12">
                                    <div id="attributesContainer" class="mt-8 row"></div>
                                    <div class="mt-8 mb-6 col-md-12">
                                        <h2 id="variationName" style="font-weight: bold; color: red;font-size: 20px"></h2>
                                        <div id="czContainer">
                                            <div id="first">
                                                <div class="recordset">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>نام</label>
                                                            <input type="text" id="value" class="form-control" name="variation_values[value][]"/>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>قیمت</label>
                                                            <input type="text" id="value" class="form-control" name="variation_values[price][]"/>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>تعداد</label>
                                                            <input type="text" id="value" class="form-control" name="variation_values[quantity][]"/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@section('script')
    @include('master.section.editor')
    <script src="/admin/js/jquery.czMore.js"></script>
    <script>
        $('#attributeContainer').hide();
        $('#czContainer').czMore();
        $('#categorySelect').on('changed.bs.select', function () {
            let categoryId = $(this).val();
            $.get(`{{ url('/master/category-attributes/${categoryId}') }}` ,
                function(response , status){
                if(status == 'success'){
                    $('#attributesContainer').find('input.att').remove();
                    $('#attributesContainer').find('label.att').remove();
                    $('#attributesContainer').find('div.att').remove();
                    $('#attributeContainer').fadeIn();
                    response.attributes.forEach(attribute => {
                        let attributeFormGroup = $('<div/>' , {
                            class : 'col-md-3 att'
                        });
                        attributeFormGroup.append($('<label/>' , {
                            text : attribute.name,
                            class : 'att',
                        }));
                        attributeFormGroup.append( $('<input/>' , {
                            class : 'att',
                            type : 'text',
                            name : `attribute_ids[${attribute.id}]`
                        }));
                        $('#attributesContainer').append(attributeFormGroup);
                    });
                    $('#variationName').text("ایجاد  تنوع محصول بر اساس: " + response.variation.name);
                }else{
                    alert('error');
                }
            }).fail(function(){
                alert('error');
            })
        });
    </script>
@endsection
