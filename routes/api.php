<?php


use App\Http\Controllers\Front\HomePageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\authCotroller;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/auth/register', [authCotroller::class, 'register']);

Route::post('/auth/login', [authCotroller::class, 'loginUser']);


// Route::group(['middleware'=>['auth:sanctum']],function(){
//     Route::get('/user',function(Request $request){
//         return $request->User(); 
//          Route::post('/makePaymentOnline',[HomePageController::class,'makePaymentOnline']);
//     });
//     Route::post('/updateUser',[authCotroller::class,'updateUser']);
//     Route::post('/auth/logout',function(Request $request){
//       auth()->user()->tokens()->delete();
//       return [
//         'message'=>"tokens revokes" 
//       ];
// });

// });
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CORRECTED: Moved the route here
    Route::post('/makePaymentOnline', [HomePageController::class, 'makePaymentOnline']);
    Route::post('/getMyOrders', [HomePageController::class, 'getMyOrders']);
    Route::post('/MyOrdersDetails', [HomePageController::class, 'MyOrdersDetails']);

    Route::post('/updateUser', [authCotroller::class, 'updateUser']);

    Route::post('/auth/logout', function (Request $request) {
        auth()->user()->tokens()->delete();
        return [
            'message' => "tokens revokes"
        ];
    });
});


//getHomeData
Route::get('/getHomeData', [HomePageController::class, 'getHomeData']);

Route::get('/getHeaderCategoriesData', [HomePageController::class, 'getCategoriesData']);

Route::post('/getCategoryData', [HomePageController::class, 'getCategoryData']);

Route::post('/getUserData', [HomePageController::class, 'getUserData']);

Route::post('/getCartData', [HomePageController::class, 'getCartData']);

Route::post('/addToCart', [HomePageController::class, 'addToCart']);

Route::post('/removeCartData', [HomePageController::class, 'removeCartData']);


Route::get('/getProductData/{item_code?}/{slug?}', [HomePageController::class, 'getProductData']);

Route::post('/addCoupon', [HomePageController::class, 'addCoupon']);

Route::post('/removeCoupon', [HomePageController::class, 'removeCoupon']);

Route::post('/getUserCoupon', [HomePageController::class, 'getUserCoupon']);

Route::post('/getPincodeDetails', [HomePageController::class, 'getPincodeDetails']);

Route::post('/placeOrder', [HomePageController::class, 'placeOrder']);
