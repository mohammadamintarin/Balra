@if($brand->content != null)
    <div class="content font-iransans leading-10">
        <h2 class="text-2xl font-peyda">{{$brand->name}}</h2>
        <div class="data_more_less mt-6">
            <div class="data_more_less_inner" data-height="3600" data-increase-by="600">
                <div class="data_more_less_body">
                    {!! $brand->content !!}
                </div>
            </div>
            <a href="#" class="action_more more_less_action btn">مطالعه بیشتر</a>
            <a href="#" class="action_less more_less_action btn">مطالعه کمتر</a>
        </div>
    </div>

@endif
