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
                        ویرایش {{$category->name}}
                    </div>
                    <div>
                        <svg class="w-7 h-7"><use href="#category"></use></svg>
                    </div>
                </div>
                <form action="{{route('master.category.update' , ['category' => $category->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="body p-4 py-9">
                        @include('master.section.error')
                        <div class=" grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-2">
                                <label>نام دسته‌بندی</label>
                                <input type="text" name="name" value="{{$category->name}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان انگلیسی</label>
                                <input type="text" name="en" value="{{$category->en}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>والد</label>
                                <select name="parent">
                                    <option value="0" selected> بدون والد</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}" {{$category->id == $item->id ? "selected" : " "}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="attribute">ویژگی</label>
                                <select class="selectpicker" data-live-search="true" multiple  id="attributeSelect" name="attribute_ids[]" >
                                    @foreach($attributes as $attribute)
                                        <option value="{{$attribute->id}}" {{  in_array($attribute->id , $category->attributes()->pluck('attributes.id')->toArray() ) ? 'selected' : '' }}> {{$attribute->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="filter">ویژگی قابل فیلتر</label>
                                <select class="selectpicker" id="attributeIsFilterSelect" multiple  name="attribute_is_filter_ids[]" >
                                    @foreach($category->attributes()->wherePivot('filter' , 1)->get() as $item)
                                        <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="sm:col-span-2">
                                <label>تنوع</label>
                                <select class="selectpicker" id="variationSelect"  name="variation" >
                                    <option value="{{$category->attributes()->wherePivot('variation' , 1)->first()->id}}" selected>{{$category->attributes()->wherePivot('variation' , 1)->first()->name}}</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label>عنوان سئو</label>
                                <input type="text" name="title" value="{{$category->title}}" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label>توضیحات سئو</label>
                                <input type="text" name="description" value="{{$category->description}}">
                            </div>
                            <div class="sm:col-span-2">
                                <label>لینک کنونیکال</label>
                                <input type="text" name="canonical" value="{{$category->canonical}}">
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block">محتوا</label>
                            <textarea id="editor" name="contents">{!! $category->content !!}</textarea>
                        </div>
                    </div>
                    <div class="footer flex justify-between items-center border-t border-gray-200 p-5 px-10">
                        <div class="search">
                            <div class="upload">
                                <label for="myfile">Select a file:</label>
                                <input type="file" id="myfile" name="file">
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
    <script>
        $('.selectpicker').selectpicker({
            'title' : 'انتخاب ویژگی'
        });

        $('#attributeSelect').on('changed.bs.select', function () {

            let attributesSelected = $(this).val();
            let attributes = @json($attributes);
            let attributeForFilter = [];

            attributes.map((attribute) => {
                $.each(attributesSelected , function(i, element){
                    if(attribute.id == element){
                        attributeForFilter.push(attribute);
                    }
                });
            });

            $("#attributeIsFilterSelect").find('option').remove();
            $("#variationSelect").find("option").remove();
            attributeForFilter.forEach((element)=>{

                let attributeFilterOption = $( "<option/>" , {
                    value : element.id,
                    text : element.name,
                });
                let variationOption = $("<option/>" , {
                    value : element.id,
                    text : element.name
                });

                $("#attributeIsFilterSelect").append(attributeFilterOption);
                $("#attributeIsFilterSelect").selectpicker('refresh');
                $("#variationSelect").append(variationOption);
                $("#variationSelect").selectpicker('refresh');
            });
        });
        $('#attributeIsFilterSelect').selectpicker({
            'title' : 'انتخاب ویژگی'
        });
        $('#variationSelect').selectpicker({
            'title' : 'انتخاب متغیر'
        });
    </script>
@endsection
