<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home\AddressController;
use App\Http\Controllers\Home\ArticleController as HomeArticleController;
use App\Http\Controllers\Home\BlogController as HomeBlogController;
use App\Http\Controllers\Home\BrandController as HomeBrandController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\CommentController;
use App\Http\Controllers\Home\ContactController as HomeContactController;
use App\Http\Controllers\Home\FaqController as HomeFaqController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductCommentController as HomeProductCommentController;

;

use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\SiteMapController;
use App\Http\Controllers\Home\SnapppayController;
use App\Http\Controllers\Home\TagController as HomeTagController;
use App\Http\Controllers\Home\TypeController as HomeTypeController;
use App\Http\Controllers\Home\OrderController as HomeOrderController;
use App\Http\Controllers\Home\WishListController;
use App\Http\Controllers\Home\ProfileController;
use App\Http\Controllers\Master\ArticleController;
use App\Http\Controllers\Master\AttributeController;
use App\Http\Controllers\Master\BannerController;
use App\Http\Controllers\Master\BlogController;
use App\Http\Controllers\Master\BrandController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\ContactController;
use App\Http\Controllers\Master\CouponController;
use App\Http\Controllers\Master\DiscountController;
use App\Http\Controllers\Master\FaqController;
use App\Http\Controllers\Master\IncreaseController;
use App\Http\Controllers\Master\MasterController;
use App\Http\Controllers\Master\OrderController;
use App\Http\Controllers\Master\PermissionController;
use App\Http\Controllers\Master\ProductCommentController;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Master\ProductImageController;
use App\Http\Controllers\Master\ReportController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\SliderController;
use App\Http\Controllers\Master\TagController;
use App\Http\Controllers\Master\TypeController;
use App\Http\Controllers\Master\UserController;
use Ghasedak\GhasedakApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('master')->name('master.')->group(function () {
    Route::get('/', [MasterController::class, 'index'])->name('home');
    Route::resource('/user', UserController::class);
    Route::get('/user/{user}/address', [UserController::class, 'address'])->name('user.address');
    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('/blog', BlogController::class);
    Route::resource('/article', ArticleController::class);
    Route::resource('/attribute', AttributeController::class);
    Route::resource('/brand', BrandController::class);
    Route::resource('/type', TypeController::class);
    Route::resource('/tag', TagController::class);
    Route::resource('/slider', SliderController::class);
    Route::resource('/banner', BannerController::class);
    Route::resource('/contact', ContactController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/order', OrderController::class);
    Route::get('/failed-order', [OrderController::class, 'failed']);
    Route::put('/order/{order}/send-code', [OrderController::class, 'sendCode'])->name('order.send.code');
    Route::put('/order/{order}/calltobuy', [OrderController::class, 'callToBuy'])->name('order.call.to.buy');
    Route::put('/order/{order}/calltosendcomment', [OrderController::class, 'callToSendComment'])->name('order.call.to.send.comment');
    Route::get('/order/{order}/change-to-registered', [OrderController::class, 'changeToRegistered'])->name('order.change.to.registered');
    Route::get('/order/{order}/change-to-fail', [OrderController::class, 'changeToFail'])->name('order.change.to.fail');
    Route::get('/order/{order}/change-status', [OrderController::class, 'changeStatus'])->name('order.change.type');
    Route::get('/order/{order}/change-status-snapp', [OrderController::class, 'changeStatusSnapp'])->name('order.change.status.snapp');
    Route::post('/order/change-item-quantity', [OrderController::class, 'changeItemQuantity'])->name('order.change.item.quantity');
    Route::get('/order/{order}/change-item-status', [OrderController::class, 'changeItemStatus'])->name('order.change.item.status');

    Route::resource('/coupon', CouponController::class);
    Route::resource('/discount', DiscountController::class);
    Route::get('/discount/{discount}', [DiscountController::class, 'changeToDefualt'])->name('discount.changeToDefualt');
    Route::resource('/faq', FaqController::class);
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes']);
    Route::resource('/product', ProductController::class);
    Route::get('/product/{product}/image', [ProductImageController::class, 'edit'])->name('product.image.edit');
    Route::delete('/product/{product}/destroy-image', [ProductImageController::class, 'destroy'])->name('product.image.destroy');
    Route::put('/product/{product}/primary-image', [ProductImageController::class, 'primary'])->name('product.image.primary');
    Route::post('/product/{product}/add-image', [ProductImageController::class, 'add'])->name('product.image.add');
    Route::get('/product/{product}/category/edit', [ProductController::class, 'editCategory'])->name('product.category.edit');
    Route::put('/product/{product}/category/update', [ProductController::class, 'updateCategory'])->name('product.category.update');
    Route::get('/product-comment', [ProductCommentController::class, 'index'])->name('product.comment');
    Route::get('/product-comment-detail/{productComment}', [ProductCommentController::class, 'detail'])->name('product.comment.detail');
    Route::get('/product-comment-change-status/{productComment}', [ProductCommentController::class, 'changeStatus'])->name('product.comment.change.status');
    Route::post('/product-comment-reply', [ProductCommentController::class, 'reply'])->name('product.comment.reply');
    //    CKEDITOR Upload Image   //
    Route::post('/upload-image', [MasterController::class, 'contentUploadImage']);
    Route::resource('/user', UserController::class);
    Route::get('/report', [ReportController::class, 'index']);
    Route::resource('/increase', IncreaseController::class);
});


Route::prefix('/profile')->middleware('auth')->name('profile.')->group(callback: function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/address', [AddressController::class, 'index'])->name('address');
    Route::post('/add-address', [AddressController::class, 'store'])->name('add.address');
    Route::get('/order', [HomeOrderController::class, 'index'])->name('order');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('update.address');
//    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
//    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
//    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
//    Route::get('/orders', [CartController::class, 'usersProfileIndex'])->name('orders.index');
//    Route::get('/orders/{order:id}', [CartController::class, 'usersOrderShow'])->name('orders.detail');
});

Route::prefix('/')->name('home.')->group(function () {
    // Categories redirect
    Route::redirect('/category/cycling-jerseys', '/category/cycling-clothes', 301);
    Route::redirect('/category/cycling-clothe', '/category/cycling-jersey', 301);
    Route::redirect('/category/downhill-jerseys', '/category/downhill-jersey', 301);
    Route::redirect('/category/cycling-scarfs', '/category/cycling-scarf', 301);
    // Clothes redirect
    Route::redirect('/products/scott-evo-cycling-jersey', '/cycling-clothes/scott-evo-clothes', 301);
    Route::redirect('/products/lampre-merida-cycling-jersey', '/cycling-clothes/lampre-merida-clothes', 301);
    Route::redirect('/products/scott-sram-cycling-jersey', '/cycling-clothes/scott-sram-clothes', 301);
    Route::redirect('/products/bora-2021-team-cycling-jersey', '/cycling-clothes/bora-2021-team-short-sleeve-clothes', 301);
    Route::redirect('/products/scott-rc-red-cycling-jersey', '/cycling-clothes/scott-rc-red-clothes', 301);
    Route::redirect('/products/scott-rc-yellow-cycling-jersey', '/cycling-clothes/scott-rc-yellow-clothes', 301);
    Route::redirect('/products/scott-rc-orange-cycling-jersey', '/cycling-clothes/scott-rc-gray-orange-clothes', 301);
    Route::redirect('/products/scott-rc-white-cycling-jersey', '/cycling-clothes/scott-rc-white-clothes', 301);
    Route::redirect('/products/giant-alpecin-black-cycling-jersey', '/cycling-clothes/giant-alpecin-black-clothes', 301);
    Route::redirect('/products/giant-alpecin-white-long-sleeve-cycling-jersey', '/cycling-clothes/giant-alpecin-white-clothes', 301);
    Route::redirect('/products/giant-alpecin-black-cycling-jersey-2', '/cycling-clothes/giant-alpecin-black-short-sleeve-clothes', 301);
    Route::redirect('/products/giant-elevate-short-sleeve-cycling-jersey', '/cycling-clothes/giant-elevate-short-sleeve-clothes', 301);
    Route::redirect('/products/ktm-cadmium-cycling-jersey', '/cycling-clothes/ktm-cadmium-short-sleeve-clothes', 301);
    Route::redirect('/products/scott-rc-10-yellow-2019-long-sleeve-cycling-jersey', '/cycling-clothes/scott-rhombus-yellow-clothes', 301);
    Route::redirect('/products/scott-rc-10-blue-2019-long-sleeve-cycling-jersey', '/cycling-clothes/scott-rhombus-blue-clothes', 301);
    Route::redirect('/products/giant-elevate-cycling-jersey', '/cycling-clothes/giant-elevate-clothes', 301);
    Route::redirect('/products/live-race-day-white-long-sleeve-cycling-jersey', '/cycling-clothes/live-race-day-white-clothes', 301);
    Route::redirect('/products/live-race-day-black-long-sleeve-cycling-jersey', '/cycling-clothes/live-race-day-black-clothes', 301);
    Route::redirect('/products/specialized-sl-white-cycling-jersey', '/cycling-clothes/specialized-sl-white-clothes', 301);
    Route::redirect('/products/ktm-curium-cycling-clothe', '/cycling-clothes/ktm-curium-short-sleeve-clothes', 301);
    Route::redirect('/products/specialized-redin-cycling-clothe', '/specialized-redin-clothes', 301);
    Route::redirect('/products/specialized-sl-cycling-clothe', '/specialized-sl-black-clothes', 301);
    Route::redirect('/products/specialized-grayson-cycling-clothe', '/cycling-clothes/specialized-grayson-clothes', 301);
    Route::redirect('/scott-polluelo-cycling-clothe', '/cycling-clothes/scott-polluelo-clothes', 301);
    Route::redirect('/products/scott-rc-2023-orange-cycling-clothe', '/cycling-clothes/scott-treasures-clothes', 301);
    Route::redirect('/products/specialized-pale-cycling-clothe', '/cycling-clothes/specialized-pale-clothes', 301);
    Route::redirect('/products/scott-rc-20-red-cycling-clothe', '/cycling-clothes/scott-rc-20-red-clothes', 301);
    Route::redirect('/products/scott-rc-20-yellow-cycling-clothe', '/cycling-clothes/scott-rc-20-yellow-clothes', 301);
    Route::redirect('/products/scott-rc-20-white-cycling-clothe', '/cycling-clothes/scott-rc-20-white-clothes', 301);
    Route::redirect('/products/scott-rc-20-blue-cycling-clothe', '/cycling-clothes/scott-rc-20-blue-clothes', 301);
    Route::redirect('/products/scott-mitchelton-black-cycling-clothe', '/cycling-clothes/scott-mitchelton-black-clothes', 301);
    Route::redirect('/products/scott-naranja-cycling-clothe', '/cycling-clothes/scott-naranja-clothes', 301);
    Route::redirect('/products/scott-mitchelton-white-cycling-clothe', '/cycling-clothes/scott-mitchelton-clothes', 301);
    Route::redirect('/products/scott-2023-cycling-clothe', '/cycling-clothes/scott-comfort-clothes', 301);
    Route::redirect('/bora-2023-cycling-clothe', '/cycling-clothes/bora-glorious-clothes', 301);
    Route::redirect('/products/scott-champion-cycling-clothe', '/cycling-clothes/scott-champion-clothes', 301);
    // Jersey redirect
    Route::redirect('/cycling-jersey/scott-rc-2023-jersey', '/cycling-jersey/scott-comfort-jersey', 301);
    Route::redirect('/products/scott-rc-2023-long-sleeve-jersey', '/cycling-jersey/scott-comfort-jersey', 301);
    Route::redirect('/products/scott-polluelo-jersey', '/cycling-jersey/scott-polluelo-jersey', 301);
    Route::redirect('/products/bora-2023-jersey', '/cycling-jersey/bora-glorious-jersey', 301);
    Route::redirect('/products/scott-mitchelton-black-jersey', '/cycling-jersey/scott-mitchelton-black-jersey', 301);
    Route::redirect('/products/scott-mitchelton-white-jersey', '/cycling-jersey/scott-mitchelton-white-jersey', 301);
    Route::redirect('/products/giant-osmoni-red-jersey', '/cycling-jersey/giant-osmoni-red-jersey', 301);
    Route::redirect('/products/scott-rc-20-red-jersey', '/cycling-jersey/scott-rc-20-red-jersey', 301);
    Route::redirect('/products/scott-rc-20-orange-jersey', '/cycling-jersey/scott-rc-20-orange-jersey', 301);
    Route::redirect('/products/giant-cereza-jersey', '/cycling-jersey/giant-cereza-jersey', 301);
    Route::redirect('/products/giant-blanco-jersey', '/cycling-jersey/giant-blanco-jersey', 301);
    Route::redirect('/products/scott-rc-20-yellow-jersey', '/cycling-jersey/scott-rc-20-yellow-jersey', 301);
    Route::redirect('/products/scott-rc-20-green-jersey', '/cycling-jersey/scott-rc-20-green-jersey', 301);
    Route::redirect('/products/bora-2023-short-sleeve-jersey', '/cycling-jersey/bora-glorious-short-sleeve-jersey', 301);
    Route::redirect('/products/scott-naranja-jersey', '/cycling-jersey/scott-naranja-jersey', 301);
    Route::redirect('/products/giant-negro-jersey', '/cycling-jersey/giant-negro-jersey', 301);
    Route::redirect('/products/scott-rc-20-blue-jersey', '/cycling-jersey/scott-rc-20-blue-jersey', 301);
    Route::redirect('/products/giant-osmoni-blue-jersey', '/cycling-jersey/giant-osmoni-blue-jersey', 301);
    Route::redirect('/products/specialized-grayson-jersey', '/cycling-jersey/specialized-grayson-jersey', 301);
    Route::redirect('/products/lampre-merida-long-sleeve-jersey', '/cycling-jersey/lampre-merida-jersey', 301);
    Route::redirect('/products/specialized-pale-jersey', '/cycling-jersey/specialized-pale-jersey', 301);
    Route::redirect('/products/scott-rc-20-white-jersey', '/cycling-jersey/scott-rc-20-white-jersey', 301);
    Route::redirect('/products/specialized-sl-long-sleeve-jersey-white', '/cycling-jersey/specialized-sl-white-jersey', 301);
    Route::redirect('/products/giant-shimano-long-sleeve-jersey', '/cycling-jersey/giant-shimano-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-magenta', '/cycling-jersey/scott-rc-10-magenta-jersey', 301);
    Route::redirect('/products/scott-champion-long-sleeve-jersey', '/cycling-jersey/scott-champion-jersey', 301);
    Route::redirect('/products/specialized-sl-long-sleeve-jersey', '/cycling-jersey/specializedsl-black-red-jersey', 301);
    Route::redirect('/products/ktm-curium-jersey', '/cycling-jersey/ktm-curium-short-sleeve-jersey', 301);
    Route::redirect('/products/specialized-redin-long-sleeve-jersey', '/cycling-jersey/specialized-redin-jersey', 301);
    Route::redirect('/products/giant-shimano-jersey', '/cycling-jersey/giant-shimano-short-sleeve-jersey', 301);
    Route::redirect('/products/giant-pursue-jersey-blue', '/cycling-jersey/giant-pursue-short-sleeve-blue-jersey', 301);
    Route::redirect('/products/giant-rival-jersey-blue', '/cycling-jersey/giant-rival-blue-short-sleeve-jersey', 301);
    Route::redirect('/products/sky-cobalt-long-sleeve-jersey', '/cycling-jersey/sky-cobalt-jersey', 301);
    Route::redirect('/products/giant-alpecin-black-long-sleeve-jersey', '/cycling-jersey/giant-aplecin-black-jersey', 301);
    Route::redirect('/products/giant-rival-long-sleeve-jersey-red', '/cycling-jersey/giant-rival-red-jersey', 301);
    Route::redirect('/products/giant-rival-long-sleeve-jersey-blue', '/cycling-jersey/giant-rival-blue-jersey', 301);
    Route::redirect('/products/giant-pursue-long-sleeve-jersey-blue', '/cycling-jersey/giant-pursue-blue-jersey', 301);
    Route::redirect('/products/giant-elevate-jersey', '/cycling-jersey/giant-elevate-short-sleeve-jersey', 301);
    Route::redirect('/products/giant-elevate-long-sleeve-jersey', '/cycling-jersey/giant-elevate-jersey', 301);
    Route::redirect('/products/liv-race-day-long-sleeve-jersey', '/cycling-jersey/liv-race-day-white-jersey', 301);
    Route::redirect('/products/liv-race-day-long-sleeve-black-jersey', '/cycling-jersey/liv-race-day-black-jersey', 301);
    Route::redirect('/products/bora-2016-team-jersey', '/cycling-jersey/bora-green-line-short-sleeve-jersey', 301);
    Route::redirect('/products/movistar-bluesky-jersey', '/cycling-jersey/movistar-o2-jersey', 301);
    Route::redirect('/products/ktm-cadmium-jersey', '/cycling-jersey/ktm-cadmium-short-sleeve-jersey', 301);
    Route::redirect('/products/giant-alpecin-white-long-sleeve-jersey', '/cycling-jersey/giant-aplecin-withe-jersey', 301);
    Route::redirect('/products/giant-alpecin-black-jersey', '/cycling-jersey/giant-alpecin-short-sleeve-black-jersey', 301);
    Route::redirect('/products/bora-2021-jersey', '/cycling-jersey/bora-2021-short-sleeve-jersey', 301);
    Route::redirect('/products/tinkoff-saxo-jersey', '/cycling-jersey/tinkoff-saxo-short-sleeve-jersey', 301);
    Route::redirect('/products/scott-sram-jersey', '/cycling-jersey/scott-sram-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-white', '/cycling-jersey/scott-rc-10-white-jersey', 301);
    Route::redirect('/products/scott-rc-10-jersey-2019-black', '/cycling-jersey/scott-rc-10-short-sleeve-black-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-black', '/cycling-jersey/scott-rc-10-black-yellow-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-blue', '/cycling-jersey/scott-rc-10-blue-jersey', 301);
    Route::redirect('/products/lampre-merida-jersey', '/cycling-jersey/lampre-merida-short-sleeve-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-yellow', '/cycling-jersey/scott-rc-10-yellow-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-red', '/cycling-jersey/scott-rc-10-red-jersey', 301);
    Route::redirect('/products/scott-rc-10-long-sleeve-jersey-2019-gray', '/cycling-jersey/scott-rc-10-gray-jersey', 301);
    Route::redirect('/products/bmc-2014-team-jersey', '/cycling-jersey/bmc-2014-jersey', 301);
    Route::redirect('/products/scott-evo-jersey', '/cycling-jersey/scott-evo-jersey', 301);
    // General redirect
    Route::redirect('/login', '/auth', 301);

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/blog/{article:slug}', [HomeArticleController::class, 'show'])->name('article.show');
    Route::get('/contact', [HomeContactController::class, 'index'])->name('contact');
    Route::get('/faq', [HomeFaqController::class, 'index'])->name('faq');
    Route::get('/tag/{tag:slug}', [HomeTagController::class, 'show']);
    Route::get('/category/{category:slug}', [HomeCategoryController::class, 'show'])->name('category.show');
    Route::get('/brand/{brand:slug}', [HomeBrandController::class, 'show'])->name('brand.show');
    Route::get('/brands', [HomeBrandController::class, 'brands']);
    Route::get('/model/{type:slug}', [HomeTypeController::class, 'show'])->name('type.show');
    Route::get('/blog/{blog:slug}', [HomeBlogController::class, 'show'])->name('blog.show');
    Route::post('/comments/{product}', [HomeProductCommentController::class, 'store'])->name('comment.store');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart', [CartController::class, 'update'])->name('cart.update');
    Route::get('/remove-from-cart/{userID}/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('coupon.check');
    Route::get('/add-to-wishlist/{product}', [WishListController::class, 'add'])->name('wishlist.add');
    Route::get('/remove-from-wishlist/{product}', [WishListController::class, 'remove'])->name('wishlist.remove');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    // SiteMap //
    Route::get('/sitemap.xml', [SiteMapController::class, 'index']);
    Route::get('/category-sitemap.xml', [SiteMapController::class, 'categories']);
    Route::get('/brand-sitemap.xml', [SiteMapController::class, 'brands']);
    Route::get('/tag-sitemap.xml', [SiteMapController::class, 'tags']);
    Route::get('/model-sitemap.xml', [SiteMapController::class, 'models']);
    Route::get('/product-sitemap.xml', [SiteMapController::class, 'products']);
    Route::get('/blog-sitemap.xml', [SiteMapController::class, 'blogs']);
    Route::get('/article-sitemap.xml', [SiteMapController::class, 'articles']);
    Route::post('/payment', [PaymentController::class, 'payment'])->name('payment');
    Route::get('/payment-verify/{gatewayName}/{Authority}/{Status}', [PaymentController::class, 'paymentVerify'])->name('payment.verify');
    Route::get('/snap-payment', [SnapppayController::class, 'Payment'])->name('payment.snap-pay.payment');
    Route::post('/snap-payment-callback', [SnapppayController::class, 'callBackSnapPayment'])->name('payment.snap-pay.callback');
    Route::get('/{category:slug}/{product:slug}', [HomeProductController::class, 'show'])->name('product.show');

});

Route::get('/get-province-cities-list', [AddressController::class, 'getProvinceCitiesList']);
Route::get('/get-user-address-list', [AddressController::class, 'getUserAddressList']);
Route::any('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/otp', [AuthController::class, 'otp'])->name('otp');
Route::post('/resend', [AuthController::class, 'resend'])->name('resend');
Route::get('/logout', [AuthController::class, 'perform'])->name('logout');

//
//Route::get('/test' , function (){
//    $api = new GhasedakApi('1e672e7be2c62de4ee82446123d148133f51d28aae78d6e7806a57f1bd8e87d9');
//    $api->SendSimple(
//        "09122138605",  // receptor
//        "Hello World!", // message
//        "10008566" 	// choose a line number from your account
//    );
//});
Route::get('/test', function () {

    try {
        $sender = "2000400060006";        //This is the Sender number

        $message = "خدمات پیام کوتاه کاوه نگار";        //The body of SMS

        $receptor = array("09122138605");            //Receptors numbers

        $result = Kavenegar::Send($sender, $receptor, $message);

        if ($result) {
            foreach ($result as $r) {
                echo "messageid = $r->messageid";
                echo "message = $r->message";
                echo "status = $r->status";
                echo "statustext = $r->statustext";
                echo "sender = $r->sender";
                echo "receptor = $r->receptor";
                echo "date = $r->date";
                echo "cost = $r->cost";
            }
        }
    } catch (\Kavenegar\Exceptions\ApiException $e) {
        // در صورتی که خروجی وب سرویس 200 نباشد این خطا رخ می دهد
        echo $e->errorMessage();
    } catch (\Kavenegar\Exceptions\HttpException $e) {
        // در زمانی که مشکلی در برقرای ارتباط با وب سرویس وجود داشته باشد این خطا رخ می دهد
        echo $e->errorMessage();
    } catch (\Exceptions $ex) {
        // در صورت بروز خطایی دیگر
        echo $ex->getMessage();
    }


});
