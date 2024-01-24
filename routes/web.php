<?php

use App\Models\User;
use App\Models\Product;
use App\Notifications\OTP;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Face\CartController;
use App\Http\Controllers\Face\FaceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Face\OrderController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Auth\OTPAuthController;
use App\Http\Controllers\Face\AddressController;
use App\Http\Controllers\Face\CommentController;
use App\Http\Controllers\Face\CompareController;
use App\Http\Controllers\Face\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Face\WishlistController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Face\FaceProductController;
use App\Http\Controllers\Face\UserAccountController;
use App\Http\Controllers\Auth\ProviderAuthController;
use App\Http\Controllers\Admin\ProductImageController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Face\CategoryController as FaceCategoryController;

/*
|--------------------
|  Admin panel routes
|--------------------
*/

Route::get('/admin-panel/dashboard', [DashboardController::class,'chartValues'])->middleware(['auth','role:admin'])->name('dashboard');

Route::prefix('admin-panel/management')->name('admin.')->middleware(['auth','role:admin'])->group(function(){
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('tags', TagController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //working on product images: this could be in one line using resource controller but
    Route::get('product-images/{product}/edit', [ProductImageController::class, 'edit'])->name('products.images.edit');
    Route::delete('product-images/{product}/destroy', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::post('product-images/{product}/set-primary', [ProductImageController::class, 'setPrimary'])->name('products.images.set-primary');
    Route::post('product-images/{product}/update', [ProductImageController::class, 'update'])->name('products.images.update');


    //ajax relationship for product create page. could be written in API routes.
    Route::get('/category-attributes/{category}',[CategoryController::class,'getAttributes']);
});


/*
|-----------------------------
|  Face: User interface routes
|-----------------------------
*/

Route::get('/test',function(){
    // dd(url('css/admin.css') , asset('css/admin.css') , public_path('css/admin.css'));
});

Route::get('/', [FaceController::class,'index'])->name('index');
Route::get('/about-us', [FaceController::class,'aboutUs'])->name('aboutUs');
Route::get('/contact-us', [FaceController::class,'contactUs'])->name('contactUs');
Route::post('/contact-us-form', [FaceController::class,'contactUsForm'])->name('contactUsForm');
Route::get('/categories/{category:slug}',[FaceCategoryController::class,'show'])->name('face.categories.show');
Route::get('/product/{product:slug}', [FaceProductController::class,'show'])->name('face.product.show');

//compare products
Route::get('/compare',[CompareController::class,'show'])->name('compare.show');
Route::get('/compare/{product}/add',[CompareController::class,'add'])->name('compare.add');
Route::get('/compare/{product}/remove',[CompareController::class,'remove'])->name('compare.remove');

//profile routes
Route::prefix('/profile')->name('profile.')->group(function(){
    Route::resource('user-account',UserAccountController::class);
    Route::resource('address',AddressController::class);
    Route::resource('orders',OrderController::class);
    Route::get('wishlist',[WishlistController::class,'index'])->name('wishlist.index');
    Route::get('comments',[CommentController::class,'index'])->name('comments.index');;
});
//Route of ajax relationship for province-city binding
Route::get('/get-province-cities-list' , [AddressController::class, 'getProvinceCitiesList']);

//wishlist operation routes
Route::post('/wishlist/{product}/add',[WishlistController::class,'add'])->name('wishlist.add');
Route::delete('/wishlist/{product}/remove',[WishlistController::class,'remove'])->name('wishlist.remove');

//comment route: create by user
Route::post('comment/{product}/store',[CommentController::class,'store'])->name('comment.store');

// cart routes
Route::get('/cart',[CartController::class,'index'])->name('cart.show');
Route::post('/cart/{product}/add',[CartController::class,'add'])->name('cart.add');
Route::put('/cart/update',[CartController::class,'update'])->name('cart.update');
Route::get('/cart/{rowId}/remove',[CartController::class,'remove'])->name('cart.remove');
Route::get('/cart/clear',[CartController::class,'clear'])->name('cart.clear');
Route::post('/cart/check-coupon',[CartController::class,'checkCoupon'])->name('cart.check-coupon');
Route::get('/cart/checkout',[CartController::class,'checkout'])->name('cart.checkout');

//payment routes
Route::post('/payment', [PaymentController::class, 'payment'])->name('face.payment');
Route::get('/payment-verify/{gatewayName}', [PaymentController::class, 'paymentVerify'])->name('face.payment_verify');

//oAuth routes
Route::get('/auth/{provider}',[ProviderAuthController::class,'redirect'])->name('auth.provider');
Route::get('/auth/{provider}/callback',[ProviderAuthController::class,'callback']);

// OTP routes
Route::any('/otp-login' , [OTPAuthController::class , 'login'])->name('otplogin');
Route::post('/check-otp' , [OTPAuthController::class , 'checkOtp']);
Route::post('/resend-otp' , [OTPAuthController::class , 'resendOtp']);

