<section class="review dark:text-white" id="comments">
    <div
        class="mx-auto max-w-2xl  pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
        <div class="flex justify-between items-center lg:col-span-2 lg:border-l lg:border-gray-200 lg:pl-8">
            <h6 class="text-2xl font-bold  text-gray-900 sm:text-3xl">
                دیدگاه
            </h6>
            <svg class="w-6 h-6">
                <use xlink:href="#comments"></use>
            </svg>
        </div>

        <div class="lg:row-span-3 lg:mt-0">
            @auth()
                <form action="{{route('home.comment.store', ['product' => $product->id])}}"
                      class="needs-validation mx-auto max-w-xl sm:mt-3" method="post">
                    @csrf
                    <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                        @if(auth()->user()->name == null && auth()->user()->family == null)
                            <div class="sm:col-span-2">
                                <label for="name"
                                       class="block text-sm font-semibold leading-6 text-gray-900">نام </label>
                                <div class="mt-2.5">
                                    <input type="text" name="name" id="name"
                                           class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="family" class="block text-sm font-semibold leading-6 text-gray-900"> نام
                                    خانوادگی</label>
                                <div class="mt-2.5">
                                    <input type="text" name="family" id="family"
                                           class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        @else
                            <div class="sm:col-span-2">
                                <label for="name"
                                       class="block text-sm font-semibold leading-6 text-gray-900">نام </label>
                                <div class="mt-2.5">
                                    <input type="text" name="name" id="name" value="{{auth()->user()->name}}" disabled
                                           class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="family" class="block text-sm font-semibold leading-6 text-gray-900"> نام
                                    خانوادگی</label>
                                <div class="mt-2.5">
                                    <input type="text" name="family" id="family" value="{{auth()->user()->family}}"
                                           disabled
                                           class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                        @endif
                        <div class="flex justify-between">
                            <div>
                                <p for="message" class="block text-sm font-semibold leading-6 text-gray-900">امتیاز</p>
                            </div>
                            <div>
                                <div id="dataReadonlyReview"
                                     data-rating-stars="5"
                                     data-rating-value="5"
                                     data-rating-input="#rateInput">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="rate" id="rateInput">
                        <div class="sm:col-span-2">
                            <label for="message" class="block text-sm font-semibold leading-6 text-gray-900">متن
                                دیدگاه</label>
                            <div class="mt-2.5">
                            <textarea name="contents" id="message" rows="4"
                                      class="block resize-none w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10">
                        <button type="submit"
                                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            ارسال دیدگاه
                        </button>
                    </div>
                </form>
            @else
                جهت ارسال دیدگاه از
                <span><a href="/auth" style="color: red; text-decoration: dashed"> اینجا</a></span>
                با لبخند وارد شوید.
            @endauth
        </div>

        <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-l lg:border-gray-200 lg:pb-16 lg:pl-8 lg:pt-6">
            @foreach($comments as $comment)
                <div class="mr-3 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex gap-x-3 items-center">
                            <img src="{{$comment->user->avatar}}" class="rounded-full comment-avatar w-[60px] block"
                                 alt="{{$comment->user->name}} {{$comment->user->family}}">
                            <span class="">{{$comment->user->name}} {{$comment->user->family}}</span>
                            <span class="hidden lg:flex text-xs text-gray-700">{{verta($comment->created_at)->format('%d %B %Y')}}</span>
                        </div>
                        <div>
                            <div class="flex">
                                <div data-rating-stars="5"
                                     data-rating-readonly="true"
                                     data-rating-value="{{ ceil($comment->user->rates->where('product_id' , $product->id)->avg('rate')) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pr-16 text-sm">{!! $comment->content !!}</div>
                </div>
                @foreach($comment->replies as $reply)
                    <div class="mr-3 reply border-b border-gray-200 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex gap-x-3 items-center">
                                <img src="{{$reply->user->avatar}}" class="rounded-full w-[60px] comment-avatar block"
                                     alt="{{$reply->user->name}} {{$reply->user->family}}">
                                <span>{{$reply->user->name}} {{$reply->user->family}}</span>
                                <span class="text-xs text-gray-700 hidden lg:flex">{{verta($reply->created_at)->format('%d %B %Y')}}</span>
                            </div>
                        </div>
                        <div class="pr-16 reply-comment text-sm">{!! $reply->content !!}</div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
