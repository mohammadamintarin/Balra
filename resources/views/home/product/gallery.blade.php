<div class="md:flex-1">
    <div>
        <div class="flex bg-gray-100 mb-4">
            <div class="mb-4 md:px-1 hidden md:flex md:flex-col">
                <div class="flex px-2 thumbnails">
                    <img src="/images/product/{{$product->image}}" alt="{{$product->name}}" class="focus:outline-none mb-2 rounded-lg w-[200px]  bg-gray-100 flex items-center justify-center cursor-pointer border border-gray-400">
                </div>
                @foreach ($product->images as $image)
                <div class="flex px-2 thumbnails">
                    <img src="/images/product/gallery/{{$image->image}}" alt="{{ $product->name }}" class="focus:outline-none mb-2 rounded-lg w-[200px]  bg-gray-100 flex items-center justify-center cursor-pointer border border-gray-400">
                </div>
                @endforeach
            </div>
            <div class="rounded-lg bg-gray-100 mb-4 flex items-center justify-center image-gallery md:pl-4">
                <img src="/images/product/{{$product->image}}" alt="{{ $product->name }}" class="md:w-[90%] object-contain">
            </div>
        </div>
        <div class="flex mb-4 md:absolute md:-mt-36 md:px-1 md:hidden">
            <div class="flex px-2 thumbnails">
                <img src="/images/product/{{$product->image}}" alt="{{$product->name}}" class="focus:outline-none w-full rounded-lg h-24 md:h-32 bg-gray-100 flex items-center justify-center cursor-pointer border border-gray-400 shadow-md">
            </div>
            @foreach ($product->images as $image)
                <div class="flex px-2 thumbnails">
                    <img src="/images/product/gallery/{{$image->image}}" alt="{{ $product->name }}" class="focus:outline-none w-full rounded-lg h-24 md:h-32 bg-gray-100 flex items-center justify-center cursor-pointer border border-gray-400 shadow-md">
                </div>
            @endforeach
        </div>
    </div>
</div>

