<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnlinePayments;
use App\Models\PayUPaymentDetail;
use Illuminate\Support\Facades\Log;

class PayuController extends Controller
{
    public function payUMoneyView($url_token)
    {

        $payment = OnlinePayments::where(['url_token' => $url_token, 'status' => 'pending'])->first();

        // If no pending payment is found, handle it gracefully
        if (!$payment) {
            abort(404, 'Payment record not found or already processed.');
        }

        // --- Configuration ---
        $MERCHANT_KEY = env('PAYU_MERCHANT_KEY');
        $SALT = env('PAYU_SALT');
        $PAYU_BASE_URL = "https://test.payu.in"; // For production, change to "https://secure.payu.in"
        $action = $PAYU_BASE_URL . '/_payment';

        // --- Prepare Data ---
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

        // Update the record with the transaction ID that we will use
        // $payment->order_id = $txnid;
        $payment->transaction_id = $txnid;
        $payment->save();

        $posted = [
            'key'           => $MERCHANT_KEY,
            'txnid'         => $txnid,
            'amount'        => $payment->amount,
            'productinfo'   => 'Product Description',
            'firstname'     => $payment->name,
            'email'         => $payment->email,
            'phone'         => $payment->phone,
            'surl'          => route('pay.u.response'),
            'furl'          => route('pay.u.cancel'),
            'service_provider' => 'payu_paisa', // This is a mandatory parameter
        ];

        // --- Hash Calculation ---
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= $posted[$hash_var] ?? '';
            $hash_string .= '|';
        }
        $hash_string .= $SALT;
        $hash = strtolower(hash('sha512', $hash_string));

        // --- CORRECTED SECTION ---
        // Create an array of data to pass to the view.
        // We get the values from the variables we've already defined ($payment, $posted, etc.)
        $data = [
            'action'       => $action,
            'hash'         => $hash,
            'MERCHANT_KEY' => $MERCHANT_KEY,
            'txnid'        => $txnid,
            'successURL'   => $posted['surl'],      // Use 'surl' from the $posted array
            'failURL'      => $posted['furl'],      // Use 'furl' from the $posted array
            'name'         => $payment->name,       // Use 'name' from the $payment object
            'email'        => $payment->email,      // Use 'email' from the $payment object
            'amount'       => $payment->amount,     // Use 'amount' from the $payment object
            'productinfo'  => $posted['productinfo'],
        ];

        // Pass the prepared $data array to the view
        return view('payu', $data);
    }

    public function payUResponse(Request $request)
    {
        try {
            // Get transaction ID from request
            $txnId = $request->input('txnid');

            // Validate transaction ID
            if (empty($txnId)) {
                return redirect('/showPaymentThankyou/failed/no-txnid');
            }

            // Check payment status with PayU
            $checkpayment = $this->checkPayuPayment($txnId);

            // Validate PayU response
            if (!$checkpayment || !isset($checkpayment->status)) {
                return redirect('/showPaymentThankyou/failed/' . $txnId);
            }

            // Check if payment is successful
            if (
                $checkpayment->status == 1 &&
                isset($checkpayment->transaction_details) &&
                isset($checkpayment->transaction_details->$txnId) &&
                $checkpayment->transaction_details->$txnId->status == 'success'
            ) {

                // Find pending online payment record
                $onlinePay = OnlinePayments::where([
                    'transaction_id' => $txnId,
                    'status' => 'pending'
                ])->first();

                if ($onlinePay) {
                    // Update online payment status
                    $onlinePay->status = 'success';
                    $onlinePay->save();

                    // Prepare data for PayUPaymentDetail
                    $paymentDetailData = [
                        'online_payment_id' => $onlinePay->id,
                        'mihpayid' => $request->input('mihpayid'),
                        'mode' => $request->input('mode'),
                        'status' => $request->input('status'),
                        'unmappedstatus' => $request->input('unmappedstatus'),
                        'key' => $request->input('key'),
                        'txnid' => $txnId,
                        'amount' => $request->input('amount'),
                        'cardCategory' => $request->input('cardCategory'),
                        'discount' => $request->input('discount'),
                        'net_amount_debit' => $request->input('net_amount_debit'),
                        'addedon' => $request->input('addedon') ?: now(),
                        'productinfo' => $request->input('productinfo'),
                        'firstname' => $request->input('firstname'),
                        'lastname' => $request->input('lastname'),
                        'address1' => $request->input('address1'),
                        'address2' => $request->input('address2'),
                        'city' => $request->input('city'),
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),
                        'zipcode' => $request->input('zipcode'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'udf1' => $request->input('udf1'),
                        'udf2' => $request->input('udf2'),
                        'udf3' => $request->input('udf3'),
                        'udf4' => $request->input('udf4'),
                        'udf5' => $request->input('udf5'),
                        'udf6' => $request->input('udf6'),
                        'udf7' => $request->input('udf7'),
                        'udf8' => $request->input('udf8'),
                        'udf9' => $request->input('udf9'),
                        'udf10' => $request->input('udf10'),
                        'hash' => $request->input('hash'),
                        'field1' => $request->input('field1'),
                        'field2' => $request->input('field2'),
                        'field3' => $request->input('field3'),
                        'field4' => $request->input('field4'),
                        'field5' => $request->input('field5'),
                        'field6' => $request->input('field6'),
                        'field7' => $request->input('field7'),
                        'field8' => $request->input('field8'),
                        'field9' => $request->input('field9'),
                        'payment_source' => $request->input('payment_source'),
                        'pa_name	' => $request->input('pa_name	'),
                        'PG_TYPE' => $request->input('PG_TYPE'),
                        'bank_ref_num' => $request->input('bank_ref_num'),
                        'bankcode' => $request->input('bankcode'),
                        'error' => $request->input('error'),
                        'error_Message' => $request->input('error_Message'),

                    ];

                    // Remove null values to avoid database issues
                    $paymentDetailData = array_filter($paymentDetailData, function ($value) {
                        return !is_null($value);
                    });

                    // Create PayU payment detail record
                    try {
                        PayUPaymentDetail::create($paymentDetailData);
                    } catch (\Exception $e) {
                        // Log the error but don't fail the transaction
                        \Log::error('PayU Payment Detail creation failed: ' . $e->getMessage());
                    }

                    return redirect('/showPaymentThankyou/success/' . $txnId);
                } else {
                    // Online payment record not found or already processed
                    return redirect('/showPaymentThankyou/failed/' . $txnId);
                }
            } else {
                // Payment failed or status is not success
                $onlinePay = OnlinePayments::where('transaction_id', $txnId)->first();
                if ($onlinePay && $onlinePay->status == 'pending') {
                    $onlinePay->status = 'failed';
                    $onlinePay->save();
                }

                return redirect('/showPaymentThankyou/failed/' . $txnId);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('PayU Response Error: ' . $e->getMessage());

            // Update payment status to failed if transaction ID exists
            if (!empty($txnId)) {
                $onlinePay = OnlinePayments::where('transaction_id', $txnId)->first();
                if ($onlinePay && $onlinePay->status == 'pending') {
                    $onlinePay->status = 'failed';
                    $onlinePay->save();
                }
            }

            return redirect('/showPaymentThankyou/failed/' . ($txnId ?? 'error'));
        }
    }
    public function checkPayuPayment($txnid)
    {
        try {
            // Get PayU configuration from environment
            $merchantKey = env('PAYU_MERCHANT_KEY');
            $salt = env('PAYU_SALT');

            // Validate configuration
            if (empty($merchantKey) || empty($salt)) {
                \Log::error('PayU configuration missing: MERCHANT_KEY or SALT not set');
                return false;
            }

            $command = "verify_payment";

            // Generate hash for verification
            $hashString = $merchantKey . "|" . $command . "|" . $txnid . "|" . $salt;
            $hash = hash('sha512', $hashString);

            // Prepare API request data
            $postData = [
                "key" => $merchantKey,
                "command" => $command,
                "var1" => $txnid,
                "hash" => $hash,
            ];

            // Determine URL based on environment
            $isProduction = env('PAYU_PRODUCTION', false);
            $url = $isProduction
                ? "https://info.payu.in/merchant/postservice.php?form=2"  // Production
                : "https://test.payu.in/merchant/postservice.php?form=2"; // Test

            // Initialize cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_USERAGENT, 'PayU-Verification/1.0');

            // Execute cURL request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            // Check for cURL errors
            if ($curlError) {
                \Log::error('PayU API cURL Error: ' . $curlError);
                return false;
            }

            // Check HTTP status code
            if ($httpCode !== 200) {
                \Log::error('PayU API HTTP Error: ' . $httpCode . ' - Response: ' . $response);
                return false;
            }

            // Parse JSON response
            $decodedResponse = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('PayU API JSON Decode Error: ' . json_last_error_msg() . ' - Raw Response: ' . $response);
                return false;
            }

            // Log successful response for debugging (remove in production)
            if (env('APP_DEBUG', false)) {
                \Log::info('PayU Payment Verification Response: ', ['response' => $decodedResponse]);
            }

            return $decodedResponse;
        } catch (\Exception $e) {
            \Log::error('PayU Payment Verification Exception: ' . $e->getMessage());
            return false;
        }
    }



    public function payUCancel(Request $request)
    {
        return redirect('/showPaymentThankyou/failed/000000');
    }
}
