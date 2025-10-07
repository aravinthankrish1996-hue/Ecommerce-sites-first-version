<?php

use App\Http\Controllers\Admin\attributeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\brandController;
use App\Http\Controllers\Admin\categoryController;
use App\Http\Controllers\Admin\colourController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\homeBannerController;
use App\Http\Controllers\Admin\productController;
use App\Http\Controllers\Admin\profileController;
use App\Http\Controllers\Admin\sizeController;
use App\Http\Controllers\Admin\taxController;
use App\Http\Controllers\Admin\couponController;
use App\Http\Controllers\auth\authCotroller;
use App\Http\Controllers\Front\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayuController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;







Route::get('/', function () {
    return view('welcome');
});

// payu

Route::get('/payu/{url_token}', [PayuController::class, 'payUMoneyView']);
Route::post('/pay-u-response', [PayuController::class, 'payUResponse'])->name('pay.u.response');
Route::get('pay-u-cancel', [PayuController::class, 'payUCancel'])->name('pay.u.cancel');

// Route::post('/pay-u-response', [PayuController::class, 'handleResponse'])->name('pay.u.response');

// Route::post('/pay-u-response', [PayuController::class, 'payUResponse'])
//      ->withoutMiddleware([VerifyCsrfToken::class])->name('pay.u.response');
// Route::get('/pay-u-cancel', [PayuController::class, 'payUCancel'])->name('pay.u.cancel');

Route::get('/{vue_capture?}', function () {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/', function () {
    return view('index');
    // return redirect('/login');
});



Route::get('/dashboard', function () {
    return view('admin/index');
});

Route::get('/login', function () {
    return view('auth/signin');
});


Route::get('/apiDocs', function () {
    return view('apiDocs');
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('login');
});


Route::post('/login_user', [authCotroller::class, 'loginUser']);


// profile router
Route::get('/profile', [profileController::class, 'index']);

Route::post('/saveProfile', [profileController::class, 'store']);

//ome banner
Route::get('/home_banner', [homeBannerController::class, 'index']);


//update
Route::post('/updateHomeBanner', [homeBannerController::class, 'store']);


//delete


Route::get('/deleteData/{id?}/{table?}', [dashboardController::class, 'deleteData']);

//Size
Route::get('/manage_size', [sizeController::class, 'index']);


//update
Route::post('/updatesize', [sizeController::class, 'store']);

//color
Route::get('/manage_color', [colourController::class, 'index']);


//update
Route::post('/updatecolor', [colourController::class, 'store']);

//Attributer
Route::get('/attributer_name', [attributeController::class, 'index_attributer_name']);


//Attributer
Route::post('/update_attributer_name', [attributeController::class, 'store_attributer_name']);

//Attributer value
Route::get('/attributer_value', [attributeController::class, 'index_attributer_value']);


//Attributer value
Route::post('/update_attributer_value', [attributeController::class, 'store_attributer_value']);



//category
Route::get('/category', [categoryController::class, 'index']);


//update
Route::post('/update_category', [categoryController::class, 'store']);

//category value
Route::get('/category_attributer', [categoryController::class, 'index_category_attribute']);


//category value
Route::post('/update_category_attributer', [categoryController::class, 'store_category_attributer']);


//ome brand
Route::get('/brands', [brandController::class, 'index']);


//update
Route::post('/updateBrand', [brandController::class, 'store']);

//ome Taxs
Route::get('/tax', [taxController::class, 'index']);


//update
Route::post('/updateTax', [taxController::class, 'store']);

//ome Product
Route::get('/product', [productController::class, 'index']);
Route::get('/manage_product/{id?}', [productController::class, 'view_product']);
Route::post('/getAttributes', [productController::class, 'getAttributes'])->name('getAttributes');;

//update product
Route::post('/updateProduct', [productController::class, 'store']);


Route::get('/changeSlug', [HomePageController::class, 'changeSlug']);

//Coupon
Route::post('/updatecoupon', [couponController::class, 'store']);


Route::get('/manage_coupon', [couponController::class, 'index']);

// web.php
// Change the route method from POST to GET
// Route::get('/CreatePayment/{url_token?}', [HomePageController::class, 'CreatePayment']);


// Route::get('/createPayment/{url_token}', [HomePageController::class, 'createPayment'])->name('create.payment');

// Route::post('pay-u-response', [HomePageController::class, 'payUResponse'])->name('pay.u.response');
// Route::get('pay-u-cancel', [HomePageController::class, 'payUCancel'])->name('pay.u.cancel');
