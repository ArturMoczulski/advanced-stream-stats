<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Process a subscription checkout
     *
     * @return \Inertia\Response
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return response()->json([
                'success' => false,
                'message' => 'This user already have an active subscription'
            ]);
        }

        $plan = SubscriptionPlan::find($request->subscriptionPlanId);

        $braintreeResponse = $this->braintreeTransaction($user, $plan, $request->paymentMethodNonce);

        if (!$braintreeResponse['success']) {
            return response()->json($braintreeResponse);
        }

        if (!$plan->activate(Auth::user())) {

            $voidResult = $this->braintreeVoid($braintreeResponse['transactionId']);

            return response()->json([
                'success' => false,
                'voidResult' => $voidResult
            ]);
        }

        return response()->json([
            'success' => true,
            'transactionId' => $braintreeResponse['transactionId']
        ]);
    }

    /**
     * Process a transaction with Braintree
     * 
     * @param App\Models\User $user
     * @param App\Models\SubscriptionPlan $plan
     * @param string $nonce
     * @return array
     */
    public function braintreeTransaction(User $user, SubscriptionPlan $plan, $nonce)
    {
        $gateway = new \Braintree\Gateway([
            'environment' => config('app.braintree.env'),
            'merchantId' => config('app.braintree.merchantId'),
            'publicKey' => config('app.braintree.publicKey'),
            'privateKey' => config('app.braintree.privateKey')
        ]);

        $result = $gateway->transaction()->sale([
            'amount' => $plan->price,
            'paymentMethodNonce' => $nonce,
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
            $response['message'] = $message;
        } else {
            $message = '';
            foreach($result->errors->deepAll() AS $error) {
              $message .= $error->code . ": " . $error->message . "\n";
            }
            $response['message'] = $message;
        }
        
        return $response;
    }

    /**
     * Process a void with Braintree
     * 
     * @param string $transactionId
     * @return array
     */
    public function braintreeVoid($transactionId)
    {
        $gateway = new \Braintree\Gateway([
            'environment' => config('app.braintree.env'),
            'merchantId' => config('app.braintree.merchantId'),
            'publicKey' => config('app.braintree.publicKey'),
            'privateKey' => config('app.braintree.privateKey')
        ]);

        $result = $gateway->transaction()->void($transactionId);
        
        return $result;
    }
}
