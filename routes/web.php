<?php
use App\http\Controllers\Admin\adminController;
use App\http\Controllers\Admin\categoryController;
use App\http\Controllers\Admin\couponController;
use App\http\Controllers\Admin\sizeController;
use App\http\Controllers\Admin\taxController;
use App\http\Controllers\Admin\colorController;
use App\http\Controllers\Admin\brandController;
use App\http\Controllers\Admin\productController;
use App\http\Controllers\Admin\customerController;
use App\http\Controllers\Front\frontController;
use App\http\Controllers\Admin\bannerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[frontController::class,'index']);
Route::get('category/{id}',[frontController::class,'category']);
Route::get('product/{id}',[frontController::class,'product']);
Route::get('search/{str}',[frontController::class,'search']);
Route::get('registration',[frontController::class,'registration']);
Route::post('registration_process',[frontController::class,'registration_process'])->name('registration.registration_process');
Route::post('login_process',[frontController::class,'login_process'])->name('login.login_process');
Route::get('logout', function () {
    session()->forget('FRONT_USER_LOGIN');
    session()->forget('FRONT_USER_ID');
    session()->forget('FRONT_USER_NAME');
    session()->forget('USER_TEMP_ID');
    return redirect('/');
});
Route::get('/verification/{id}',[frontController::class,'email_verification']);
Route::post('forgot_password',[frontController::class,'forgot_password']);
Route::post('forgot_password_change_process',[frontController::class,'forgot_password_change_process']);
Route::get('/forgot_password_change/{id}',[frontController::class,'forgot_password_change']);
Route::get('admin',[adminController::class,'index']);
Route::post('admin/auth',[adminController::class,'auth'])->name('admin.auth');
Route::post('add_to_cart',[frontController::class,'add_to_cart']);
Route::get('cart',[frontController::class,'cart']);
Route::get('/checkout',[frontController::class,'checkout']);
Route::post('apply_coupon_code',[frontController::class,'apply_coupon_code']);
Route::post('remove_coupon_code',[frontController::class,'remove_coupon_code']);
Route::post('place_order',[frontController::class,'place_order']);
Route::get('/order_placed',[frontController::class,'order_placed']);
Route::get('/order_fail',[frontController::class,'order_fail']);
Route::get('/instamojo_payemtn_redirect',[frontController::class,'instamojo_payemtn_redirect']);


Route::group(['middleware'=>'admin_auth'],function(){
    Route::get('admin/dashboard',[adminController::class,'dashboard']);
    Route::get('admin/category',[categoryController::class,'index']);
    Route::get('admin/category/manage_category',[categoryController::class,'manage_category']);
    Route::get('admin/category/manage_category/{id}',[categoryController::class,'manage_category']);
    Route::post('admin/category/manage_category_process',[categoryController::class,'manage_category_process'])->name('category.manage_category_process');
    Route::get('admin/category/delete/{id}',[categoryController::class,'delete']);
    Route::get('admin/category/status/{status}/{id}',[categoryController::class,'status']);

    Route::get('admin/coupon',[couponController::class,'index']);
    Route::get('admin/coupon/manage_coupon',[couponController::class,'manage_coupon']);
    Route::get('admin/coupon/manage_coupon/{id}',[couponController::class,'manage_coupon']);
    Route::post('admin/coupon/manage_coupon_process',[couponController::class,'manage_coupon_process'])->name('coupon.manage_coupon_process');
    Route::get('admin/coupon/delete/{id}',[couponController::class,'delete']);
    Route::get('admin/coupon/status/{status}/{id}',[couponController::class,'status']);

    Route::get('admin/size',[sizeController::class,'index']);
    Route::get('admin/size/manage_size',[sizeController::class,'manage_size']);
    Route::get('admin/size/manage_size/{id}',[sizeController::class,'manage_size']);
    Route::post('admin/size/manage_size_process',[sizeController::class,'manage_size_process'])->name('size.manage_size_process');
    Route::get('admin/size/delete/{id}',[sizeController::class,'delete']);
    Route::get('admin/size/status/{status}/{id}',[sizeController::class,'status']);

    Route::get('admin/tax',[taxController::class,'index']);
    Route::get('admin/tax/manage_tax',[taxController::class,'manage_tax']);
    Route::get('admin/tax/manage_tax/{id}',[taxController::class,'manage_tax']);
    Route::post('admin/tax/manage_tax_process',[taxController::class,'manage_tax_process'])->name('tax.manage_tax_process');
    Route::get('admin/tax/delete/{id}',[taxController::class,'delete']);
    Route::get('admin/tax/status/{status}/{id}',[taxController::class,'status']);

    Route::get('admin/customer',[customerController::class,'index']);
    Route::get('admin/customer/show/{id}',[customerController::class,'show']);
    
    Route::get('admin/customer/status/{status}/{id}',[customerController::class,'status']);

    Route::get('admin/color',[colorController::class,'index']);
    Route::get('admin/color/manage_color',[colorController::class,'manage_color']);
    Route::get('admin/color/manage_color/{id}',[colorController::class,'manage_color']);
    Route::post('admin/color/manage_color_process',[colorController::class,'manage_color_process'])->name('color.manage_color_process');
    Route::get('admin/color/delete/{id}',[colorController::class,'delete']);
    Route::get('admin/color/status/{status}/{id}',[colorController::class,'status']);

    Route::get('admin/brand',[brandController::class,'index']);
    Route::get('admin/brand/manage_brand',[brandController::class,'manage_brand']);
    Route::get('admin/brand/manage_brand/{id}',[brandController::class,'manage_brand']);
    Route::post('admin/brand/manage_brand_process',[brandController::class,'manage_brand_process'])->name('brand.manage_brand_process');
    Route::get('admin/brand/delete/{id}',[brandController::class,'delete']);
    Route::get('admin/brand/status/{status}/{id}',[brandController::class,'status']);

    Route::get('admin/banner',[bannerController::class,'index']);
    Route::get('admin/banner/manage_banner',[bannerController::class,'manage_banner']);
    Route::get('admin/banner/manage_banner/{id}',[bannerController::class,'manage_banner']);
    Route::post('admin/banner/manage_banner_process',[bannerController::class,'manage_banner_process'])->name('banner.manage_banner_process');
    Route::get('admin/banner/delete/{id}',[bannerController::class,'delete']);
    Route::get('admin/banner/status/{status}/{id}',[brandController::class,'status']);

    Route::get('admin/product',[productController::class,'index']);
    Route::get('admin/product/manage_product',[productController::class,'manage_product']);
    Route::get('admin/product/manage_product/{id}',[productController::class,'manage_product']);
    Route::post('admin/product/manage_product_process',[productController::class,'manage_product_process'])->name('product.manage_product_process');
    Route::get('admin/product/delete/{id}',[productController::class,'delete']);
    Route::get('admin/product/product_image_delete/{pimageid}/{id}',[productController::class,'product_image_delete']);
    Route::get('admin/product/product_attr_delete/{paid}/{id}',[productController::class,'product_attr_delete']);
    Route::get('admin/product/status/{status}/{id}',[productController::class,'status']);

    
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->flash('errors','Logout Successfully');
        return redirect('admin');
    });
});
