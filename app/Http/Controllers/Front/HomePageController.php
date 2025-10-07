<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeBanner;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\ProductAttribute;
use App\Models\Colour;
use App\Models\Size;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttr;
use App\Models\Pincode;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserOrder;
use App\Models\UserOrdersDetail;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Arr;
use App\Models\TempUsers;
use App\Models\OnlinePayments;
use App\Models\UserCouponCart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Auth;
use Illuminate\Support\Facades\Log;






use Illuminate\Database\Query\Builder as QueryBuilder;


class HomePageController extends Controller
{
    use ApiResponse;

    // Assuming this is in a controller like Api/CategoryController.php

    public function getCategoriesData()
    {
        $categories = Category::with('subcategories')->where('parent_category_id', Null)->get();


        return response()->json([
            'success' => true,
            'message' => 'Successfully data fetched',
            'data'    => $categories
        ], 200);
    }
    public function getHomeData()
    {
        $data = [];

        $data['banner'] = HomeBanner::get();
        $data['categories'] = Category::with('products:id,category_id,name,slug,image,item_code')->get();
        $data['brands'] = Brand::get();
        $data['products'] = Product::with('productAttributer')->select('id', 'category_id', 'image', 'name', 'slug', 'item_code')->get();


        return $this->success($data, 'Successfully data fetched');
    }

    public function getCategoryData(Request $request)
    {
        $slug = $request->slug;
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return $this->error('Category not found.', 404);
        }

        $products = $this->getFilterProducts(
            $category->id,
            $request->brand,
            $request->size,
            $request->color,
            $request->attributer,
            $request->lowPrice,
            $request->highPrice
        );

        if (is_null($category->parent_category_id)) {
            $relatedCategories = Category::where('parent_category_id', $category->id)->get();
        } else {
            $relatedCategories = Category::where('parent_category_id', $category->parent_category_id)->get();
        }

        $data = [
            'products'   => $products,
            'categories' => $relatedCategories,
            'brands'     => Brand::get(),
            'sizes'      => Size::get(),
            'colors'     => Colour::get(),
            'lowPrice'   => ProductAttr::min('price'),
            'highPrice'  => ProductAttr::max('price'),
            'category'   => $category,
            'attributer' => CategoryAttribute::where('category_id', $category->id)->with('attributer')->get(),
        ];

        return $this->success($data, 'Successfully data fetched');
    }


    public function getFilterProducts($category_id, $brands = [], $sizes = [], $colors = [], $attributer = [], $lowPrice = null, $highPrice = null)
    {

        $query = Product::where('category_id', $category_id);


        if (!empty($brands)) {
            $query->whereIn('brand_id', $brands);
        }


        if (!empty($attributer)) {
            $query->whereHas('attributes', function ($subQuery) use ($attributer) {

                $subQuery->whereIn('attribute_values_id', $attributer);
            });
        }


        if (!empty($sizes) || !empty($colors) || (!empty($lowPrice) && !empty($highPrice))) {
            $query->whereHas('productAttributer', function ($subQuery) use ($sizes, $colors, $lowPrice, $highPrice) {
                // Apply size filter
                if (!empty($sizes)) {
                    $subQuery->whereIn('size_id', $sizes);
                }

                // Apply color filter
                if (!empty($colors)) {
                    $subQuery->whereIn('color_id', $colors);
                }

                // Apply price range filter
                if (!empty($lowPrice) && !empty($highPrice)) {
                    $subQuery->whereBetween('price', [$lowPrice, $highPrice]);
                }
            });
        }

        // Now, execute the final, filtered query and paginate the results.
        $products = $query->with('productAttributer')
            ->select('id', 'category_id', 'name', 'slug', 'image', 'item_code')
            ->paginate(10);

        return $products;
    }
    public function getUserData(Request $request)
    {
        $token = $request->token;
        $checkUser = TempUsers::where('token', $token)->first();

        if (isset($checkUser->id)) {
            $data['user_type'] = $checkUser->user_type;
            $data['token'] = $checkUser->token;

            if (checkTokenExpiryInMinutes($checkUser->updated_at, 60)) {
                $token = generateRandomString();
                $checkUser->token = $token;
                $checkUser->updated_at = date('Y-m-d h:i:s a', time());
                $checkUser->save();

                $data['token'] = $token;
            } else {
            }
        } else {
            $user_id = rand(11111, 99999);
            $token = generateRandomString();
            $time = date('Y-m-d h:i:s a', time());
            TempUsers::create([
                'user_id' => $user_id,
                'token' => $token,
                'created_at' => $time,
                'updated_at' => $time
            ]);

            $data['user_type'] = 2;
            $data['token'] = $token;
        }
        return $this->success(['data' => $data], 'Successfully data fetched');
    }
    public function getProductData($item_code = '', $slug = '')
    {
        $product = Product::where('item_code', $item_code)
            ->where('slug', $slug)
            ->with([
                'productAttributer.images', // Eager load images for each attribute
                'productAttributer.sizes',  // Eager load the size for each attribute
                'productAttributer.colors'  // Eager load the color for each attribute
            ])
            ->first();
        $product['otherProducts'] = Product::where('category_id', $product->category_id)->with('productAttributer')->get();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // This will return the product with all its attributes and their related data (images, sizes, colors)
        return response()->json(['data' => ['product' => $product]]);
    }
    public function addToCart(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
            'product_id'      => 'required|exists:products,id',

            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty'             => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {

            $user = TempUsers::where('token', $request->token)->first();

            Cart::updateOrCreate(
                [
                    'user_id'         => $user->user_id,
                    'product_id'      => $request->product_id,
                    'product_attr_id' => $request->product_attr_id
                ],
                [
                    'user_id'         => $user->user_id,
                    'product_id'      => $request->product_id,
                    'product_attr_id' => $request->product_attr_id,
                    'qty'       => $request->qty,
                    'user_type' => $user->user_type
                ]
            );
        }
        return $this->success(['data' => ''], 'Product added to cart successfully');
    }

    public function getCartData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token' => 'required|exists:temp_users,token',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        }

        $userToken = TempUsers::where('token', $request->token)->first();

        // Eager load the relationships we just defined. This is very efficient.
        $cartItems = Cart::where('user_id', $userToken->user_id)
            ->with(['product', 'productAttributer'])
            ->get();

        $formattedCart = [];
        foreach ($cartItems as $item) {
            // Check if the relationships loaded correctly to prevent errors
            if ($item->product && $item->productAttributer) {
                $formattedCart[] = [
                    'id'              => $item->id,
                    'qty'             => $item->qty,
                    'product_id'      => $item->product_id,
                    'product_attr_id' => $item->product_attr_id,
                    'product' => [
                        'name'      => $item->product->name,
                        'image_url' => $item->product->image_url, // Make sure 'image_url' exists on your Product model
                    ],
                    'attribute' => [
                        'price' => $item->productAttributer->price,
                        'mrp'   => $item->productAttributer->mrp,
                    ]
                ];
            }
        }

        // The success response now contains the clean data
        return $this->success(['data' => $formattedCart], 'Successfully fetched cart data');
    }

    // A helper function for success responses (assuming you have one)
    protected function success($data, $message = 'Success')
    {
        return response()->json(['status' => 200, 'message' => $message, 'data' => $data]);
    }

    // A helper function to return an error response
    protected function error($message = 'Error', $statusCode = 400)
    {
        return response()->json(['status' => $statusCode, 'message' => $message], $statusCode);
    }

    public function removeCartData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
            'product_id'      => 'required|exists:products,id',

            'product_attr_id' => 'required|exists:product_attrs,id',
            'qty'             => 'required|numeric|min:0|not_in:0',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {

            $user = TempUsers::where('token', $request->token)->first();
            $cart = Cart::where([
                'user_id'         => $user->user_id,
                'product_id'      => $request->product_id,
                'product_attr_id' => $request->product_attr_id
            ])->first();

            if (isset($cart->id)) {
                $qty = $request->qty;
                if ($cart->qty == $qty) {
                    $cart->delete();
                } elseif ($cart->qty == $qty) {
                    $cart->qty -= $qty;
                    $cart->save();
                } else {
                    $cart->delete();
                }
            }

            return $this->success(['data' => ''], 'Product added to cart successfully');
        }
    }

    public function addCoupon(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'coupon'           => 'required|exists:coupons,name',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $coupon = Coupon::where('name', $request->coupon)->first();
            $user = TempUsers::where('token', $request->token)->first();
            $couponName = $coupon->name;
            if ($coupon->minValue <= $request->cartTotal) {
                $couponValue = $coupon->value;
                if ($coupon->type == 1) {

                    $cartotal = $request->cartTotal - $couponValue;
                    //    prx($cartotal);
                } else {
                    $couponValue = $couponValue / 100;
                    $couponValue = $request->cartTotal * $couponValue;
                    $cartotal   = $request->cartTotal - $couponValue;
                }
                UserCouponCart::updateOrCreate(
                    ['user_id' => $user->user_id],
                    ['user_id' => $user->user_id, 'coupon_id' => $coupon->id]
                );
                return $this->success(['data' => $cartotal, 'couponName' => $couponName], 'Successfully fetched cart data');
            } else {
                return $this->error(['message' => 'Coupon not found'], 404);
            }
        }
        // prx($request->all());
    }
    public function removeCoupon(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUsers::where('token', $request->token)->first();
            $couponUser = UserCouponCart::where('user_id', $user->user_id)->delete();
        }
        return $this->success([], 'Successfully fetched cart data');
    }
    public function getUserCoupon(Request $request)
    {
        $couponName = '';
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = TempUsers::where('token', $request->token)->first();
            $couponUser = UserCouponCart::where('user_id', $user->user_id)->first();

            if (isset($couponUser->id)) {
                $coupon = Coupon::where('id', $couponUser->coupon_id)->first();
                $couponName = $coupon->name;
                if ($coupon->minValue <= $request->cartTotal) {
                    $couponValue = $coupon->value;
                    if ($coupon->type == 1) {

                        $cartotal = $request->cartTotal - $couponValue;
                        //    prx($cartotal);
                    } else {
                        $couponValue = $couponValue / 100;
                        $couponValue = $request->cartTotal * $couponValue;
                        $cartotal   = $request->cartTotal - $couponValue;
                    }
                } else {
                    $couponValue = $request->cartTotal;
                }
            } else {
                $cartotal = $request->cartTotal;
            }
            return $this->success(['data' => $cartotal, 'couponName' => $couponName], 'Successfully fetched cart data');
        }
    }
    public function getPincodeDetails(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
            'pincode'         =>  'required|exists:pincodes,Pincode',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $data = Pincode::where('Pincode', $request->pincode)->first();
            return $this->success(['data' => $data], 'Successfully fetched cart data');
        }
    }
    public function placeOrder(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'token'           => 'required|exists:temp_users,token',
            'pincode'         =>  'required|exists:pincodes,Pincode',
            'firstName'      => 'required|string|max:255',
            'lastName'      => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            // 'address'      => 'required|string|max:255',
            'country'      => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'state'      => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
        } else {
            $user = $this->createUser($request->all());

            $address_id = $this->saveAddress($request->all(), $user['id']);
            $order = $this->saveOrder($request->all(), $user['id'], $address_id);

            $tempUser = TempUsers::where('token', $request->token)->first();
            Cart::where('user_id', $tempUser->user_id)->delete();
            UserCouponCart::where('user_id', $tempUser->user_id)->delete();
            $tempUser->update(['user_id' => $user['id'], 'user_type' => 1, 'token' => $user['token']]);

            $newdata['order'] = $order;
            $newdata['user'] = $user['token'];
            return $this->success(['data' => [$newdata]], 'Successfully fetched cart data');
        }
    }
    public function saveOrder($data, $user_id, $address_id)
    {

        $cart = $this->getOrderTotalValue($data);

        $order = UserOrder::create([
            'user_id' => $user_id,
            'total_value' => $cart['carttotal'],
            'coupon' => $cart['couponName'],
            'address_id' => $address_id,
            'payment_method' => $data['paymentMethod'],
            'shipping_service' => 'Standard',
        ]);

        $orderDetails = $this->saveOrderDetails($data, $user_id, $order->id);
        return $order->id;
    }
    public function saveOrderDetails($data, $user_id, $order_id)
    {
        $user = TempUsers::where('token', $data['token'])->first();
        $cart = Cart::where('user_id', $user->user_id)->get();
        $totalPrice = 0;
        foreach ($cart as $list) {
            $totalPrice = 0;
            $productAttr = ProductAttr::where('id', $list->product_attr_id)->first();
            $price = $productAttr->price * $list->qty;
            $totalPrice += $price;

            $orderDetails    = UserOrdersDetail::create([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'product_attr_id' => $list->product_attr_id,
                'total_value' => $totalPrice,
                'qty' =>  $list->qty,


            ]);
        }
        return;
    }
    public function getOrderTotalValue($data)
    {
        $couponName = '';
        $user = TempUsers::where('token', $data['token'])->First();
        $couponUser = UserCouponCart::where('user_id', $user->user_id)->first();
        $totalCartValue = $this->totalCartValue($data);

        if (isset($couponUser->id)) {
            $coupon = Coupon::where('id', $couponUser->coupon_id)->first();
            $couponName = $coupon->name;
            if ($coupon->minValue <= $totalCartValue) {
                $couponValue = $coupon->value;
                if ($coupon->type == 1) {
                    $cartotal = $totalCartValue - $couponValue;
                } else {
                    $couponValue = ($couponValue / 100) * $totalCartValue;
                    $cartotal = $totalCartValue - $couponValue;
                }
            } else {
                $cartotal = $totalCartValue;
            }
        } else {
            $cartotal = $totalCartValue;
        }


        return [
            'carttotal'  => $cartotal,
            'couponName' => $couponName
        ];
    }
    public function totalCartValue($data)
    {
        $user = TempUsers::where('token', $data['token'])->first();
        $cart = Cart::where('user_id', $user->user_id)->get();
        $totalPrice = 0;
        foreach ($cart as $list) {
            $productAttr = ProductAttr::where('id', $list->product_attr_id)->first();
            $price = $productAttr->price * $list->qty;
            $totalPrice += $price;
        }
        return $totalPrice;
    }
    public function saveAddress($data, $user_id)
    {
        $pincode = Pincode::where('Pincode', $data['pincode'])->first();

        $userAddress = UserAddress::UpdateOrCreate(
            [
                'user_id' => $user_id,
                'pincode' => $pincode->Pincode,
                'city' => $pincode->City,
                'state' => $pincode->State,
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country']

            ],
            [
                'user_id' => $user_id,
                'pincode' => $pincode->Pincode,
                'city' => $pincode->City,
                'state' => $pincode->State,
                'phone' => $data['phone'],
                'address' => $data['address'],
                'country' => $data['country']
            ]
        );
        return $userAddress->id;
    }
    public function createUser($data)
    {
        if (Auth::User()) {
            $user = Auth::User();
        } else {
            $user = User::create([
                'name' => $data['firstName'] . ' ' . $data['lastName'],
                'password' => Hash::make('' . $data['firstName'] . '@123'),
                'email' => $data['email']
            ]);
            $customer = Role::where('slug', 'customer')->first();
            $user->roles()->attach($customer);
            // $user = User::where('id',5)->first();
        }
        $user['token'] = $user->createToken('API TOKEN')->plainTextToken;
        return $user;
    }
    public function changeSlug()
    {
        $data = Product::get();

        foreach ($data as $list) {
            $result = Product::find($list->id);
            $result->slug = replaceStr($result->name);
            prx(replaceStr($result->name));
            $result->save();
        }
    }
    private function generateRandomString($length = 30)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function makePaymentOnline(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'order_id' => 'required|exists:user_orders,id',
        ]);

        $user = Auth::user();
        $order = UserOrder::where(['id' => $request->order_id, 'user_id' => $user->id])->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found or you do not have permission to access it.'], 404);
        }

        $input = [
            'name'      => $user->name, // Use user's name instead of ID
            'email'     => $user->email,
            'phone'     => $user->phone,
            'amount'    => $order->total_value,
            'order_id'  => $order->id,
            'url_token' => $this->generateRandomString(30),
        ];

        OnlinePayments::create($input);

        $url = url('/payu/' . $input['url_token']);

        // **FIX 1: Return a simple, clear JSON response.**
        // This is much easier for your frontend to handle.
        return response()->json(['payment_url' => $url], 200);
    }
    // The method name is updated for clarity, but you can keep yours.
    // public function CreatePayment($url_token)
    // {
    //     // This will now work correctly.
    //     // It will throw a 404 error if the token is not found, which is good.
    //     $payment = OnlinePayments::where(['url_token' => $url_token, 'status' => 'pending'])->first();

    //     // --- Configuration ---
    //     $MERCHANT_KEY = env('PAYU_MERCHANT_KEY');
    //     $SALT = env('PAYU_SALT');
    //     $PAYU_BASE_URL = "https://test.payu.in";
    //     $action = $PAYU_BASE_URL . '/_payment';

    //     // --- Prepare Data ---
    //     $txnid = substr(hash('sha26', mt_rand() . microtime()), 0, 20);

    //     // Update the record with the transaction ID that we will use
    //     $payment->payment_id = $txnid;
    //     $payment->save();

    //     $posted = [
    //         'key'           => $MERCHANT_KEY,
    //         'txnid'         => $txnid,
    //         'amount'        => $payment->amount,
    //         'productinfo'   => 'Product Description',
    //         'firstname'     => $payment->name,
    //         'email'         => $payment->email,
    //         'surl'          => route('pay.u.response'),
    //         'furl'          => route('pay.u.cancel'),
    //     ];

    //     // --- Hash Calculation ---
    //     $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    //     $hashVarsSeq = explode('|', $hashSequence);
    //     $hash_string = '';
    //     foreach ($hashVarsSeq as $hash_var) {
    //         $hash_string .= $posted[$hash_var] ?? '';
    //         $hash_string .= '|';
    //     }
    //     $hash_string .= $SALT;
    //     $hash = strtolower(hash('sha512', $hash_string));

    //     // Return a JSON response
    //     return response()->json([
    //         'action'        => $action,
    //         'hash'          => $hash,
    //         'MERCHANT_KEY'  => $MERCHANT_KEY,
    //         'txnid'         => $txnid,
    //         'successURL'    => $posted['surl'],
    //         'failURL'       => $posted['furl'],
    //         'name'          => $posted['firstname'],
    //         'email'         => $posted['email'],
    //         'amount'        => $posted['amount'],
    //         'productinfo'   => $posted['productinfo'],
    //     ]);
    // }

    // // You will also need methods to handle the success and cancel responses from PayU
    // public function paymentResponse(Request $request)
    // {
    //     // Handle the successful payment response from PayU here
    //     // Log the response, update order status, etc.
    //     return "Payment Successful!";
    // }

    // public function paymentCancel(Request $request)
    // {
    //     // Handle the failed/cancelled payment response from PayU here
    //     return "Payment Cancelled.";
    // }
    // public function payUResponse(Request $request)
    // {
    //     echo "<pre>";
    //     print_r($request->all());
    //     die();
    //     $txnId = $request['txnid'];
    //     $checkpayment = $this->checkPayuPayment($txnId);

    //     if (isset($checkpayment->status) && $checkpayment->status == 1 && isset($checkpayment->transaction_details) && isset($checkpayment->transaction_details->$txnId) && $checkpayment->transaction_details->$txnId->status == 'success') {
    //     }
    //     dd('Payment Successfully Done');
    // }
    // public function checkPayuPayment($txnid)
    // {
    //     // $merchantKey = env('PAYUMERCHANT_KEY');
    //     $merchantKey = env('PAYU_MERCHANT_KEY');
    //     // $salt = env('PAYUSALT'); // TEST SALT
    //     $salt = env('PAYU_SALT'); // TEST SALT
    //     // $merchantKey = env('PAYUMERCHANT_KEY');
    //     // $salt = env('PAYUSALT');
    //     $command = "verify_payment";
    //     $txnId = $txnid;

    //     // Generate hash
    //     $hashString = $merchantKey . "|" . $command . "|" . $txnId . "|" . $salt;
    //     $hash = hash('sha512', $hashString);

    //     // Prepare API request
    //     $postData = [
    //         "key" => $merchantKey,
    //         "command" => $command,
    //         "var1" => $txnId,
    //         "hash" => $hash,
    //     ];

    //     $url = "https://test.payu.in/merchant/postservice.php?form=2"; //test
    //     // $url = "https://info.payu.in/merchant/postservice.php?form=2";

    //     // cURL request
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($ch);
    //     curl_close($ch);

    //     // Parse response
    //     $response = json_decode($response);

    //     return $response;
    // }

    // public function payUCancel(Request $request)
    // {
    //     dd($_GET);
    //     dd('Payment Failed');
    // }

    public function getMyOrders(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'token' => 'required',
                'auth' => 'boolean'
            ]);

            // Get the authenticated user
            $user = Auth::user();

            if (!$user) {
                return $this->error([], 'User not authenticated', 401);
            }

            // Fetch orders with address relationship
            $orders = UserOrder::where('user_id', $user->id)
                ->with(['address', 'order_details'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Log the query for debugging
            \Log::info('Orders query result:', [
                'user_id' => $user->id,
                'orders_count' => $orders->count(),
                'orders' => $orders->toArray()
            ]);

            return $this->success(['data' => $orders], 'Orders retrieved successfully');
        } catch (\Exception $e) {
            \Log::error('Error in getMyOrders: ' . $e->getMessage());
            return $this->error([], 'Failed to retrieve orders: ' . $e->getMessage(), 500);
        }
    }
    public function MyOrdersDetails(Request $request)
    {
        try {
            // Validate request
            if (!$request->order_id) {
                return $this->error('Order ID is required', 400);
            }

            // Check if order exists and belongs to authenticated user
            $checkData = UserOrder::where([
                'user_id' => Auth::User()->id,
                'id' => $request->order_id
            ])->first();

            if (!$checkData) {
                return $this->error('Order not found or access denied', 404);
            }

            // Get order with relationships
            $data = UserOrder::where([
                'user_id' => Auth::User()->id,
                'id' => $request->order_id
            ])->with([
                'address',
                'order_details.product_attr.products'
            ])->get();

            return $this->success(['data' => $data], 'Order details retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve order details: ' . $e->getMessage(), 500);
        }
    }
}
