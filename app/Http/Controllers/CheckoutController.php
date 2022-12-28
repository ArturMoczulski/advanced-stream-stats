<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;

class CheckoutController extends Controller
{
    /**
     * Process a subscription checkout
     *
     * @return \Inertia\Response
     */
    public function checkout(Request $request)
    {
        $plan = SubscriptionPlan::find($request->subscriptionPlanId);

        $gateway = new \Braintree\Gateway([
            'environment' => config('app.braintree.env'),
            'merchantId' => config('app.braintree.merchantId'),
            'publicKey' => config('app.braintree.publicKey'),
            'privateKey' => config('app.braintree.privateKey')
        ]);

        $result = $gateway->transaction()->sale([
            'amount' => $plan->price,
            'paymentMethodNonce' => $request->paymentMethodNonce,
            // 'deviceData' => $deviceDataFromTheClient,
            'options' => [ 'submitForSettlement' => True ]
        ]);

        $response = [
            'success' => $result->success
        ];
        
        if ($result->success) {
            $response['transactionId'] = $result->transaction->id;
        } else if ($result->transaction) {
            $message = "Error processing transaction:";
            $message .= "\n  code: " . $result->transaction->processorResponseCode;
            $message .= "\n  text: " . $result->transaction->processorResponseText;
        } else {
            foreach($result->errors->deepAll() AS $error) {
              $message .= $error->code . ": " . $error->message . "\n";
            }
        }

        $response['message'] = $message;

        return response()->json($response);
    }
}
