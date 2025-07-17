@if($product->video)
    <div class="product font-peyda mt-6 mb-6" id="video">
        <div class="container">
            <div class="flex justify-between items-center lg:px-0 px-2 mb-10">
                <div class="flex items-center">
                    <h6 class="text-2xl font-bold  text-gray-900 sm:text-3xl">
                        ویدئو
                    </h6>
                </div>
                <div class="flex items-center gap-x-3 text-gray-400 lg:text-xl text-sm">
                </div>
            </div>
            <div itemid="https://www.nivor.ir/video/{{$product->video}}"  itemscope itemtype="https://schema.org/VideoObject">
                <meta itemprop="thumbnailUrl" content="https://www.nivor.ir/images/cover/{{$product->cover}}">
                <meta itemprop="uploadDate" content="{{verta($product->updated_at)->formatGregorian("Y-m-d")}}">
                <meta itemprop="name" content="{{$product->name}}">
                <meta itemprop="description" content="{{$product->description}}">
                <meta itemprop="contentUrl" content="https://www.nivor.ir/video/{{$product->video}}">
                <video width="404" height="auto" controls preload="none"
                       src="/video/{{$product->video}}"
                       poster="/images/cover/{{$product->cover}}"
                       muted="false" loop="false">
                </video>
            </div>
        </div>
    </div>
@endif
