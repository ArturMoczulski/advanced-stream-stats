<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Process a subscription checkout
     *
     * @return \Inertia\Response
     */
    public function checkout(Request $request)
    {
        // TODO: need to add db transaction support

        // TODO: need to add payment records storage
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return response()->json([
                'success' => false,
                'message' => 'This user already have an active subscription'
            ]);
        }

        DB::beginTransaction();

        $plan = SubscriptionPlan::find($request->subscriptionPlanId);

        $gateway = new \Braintree\Gateway([
            'environment' => config('app.braintree.env'),
            'merchantId' => config('app.braintree.merchantId'),
            'publicKey' => config('app.braintree.publicKey'),
            'privateKey' => config('app.braintree.privateKey')
        ]);

        $braintreeCustomer = $gateway->customer()->create([
            'firstName' => $user->name,
            'lastName' => $user->name,
            'email' => $user->email,
            'paymentMethodNonce' => $request->paymentMethodNonce
        ]);
        if (!$braintreeCustomer->success) {
            DB::rollBack();
            return response()->json($braintreeCustomer);
        }

        $braintreeSub = $gateway->subscription()->create([
            'paymentMethodToken' => $braintreeCustomer->customer->paymentMethods[0]->token,
            'planId' => "$plan->id"
        ]);
        if (!$braintreeSub->success) {
            DB::rollBack();
            return response()->json($braintreeSub);
        }

        if (!$plan->activate(Auth::user(), $braintreeSub->subscription->id)) {

            $result = $gateway->subscription()->cancel($braintreeSub->subscription->id);

            DB::rollBack();
            return response()->json([
                'success' => false,
                'cancelResult' => $result
            ]);
        }

        DB::commit();
        return response()->json([
            'success' => true,
            'braintreeSubscriptionId' => $braintreeSub->subscription->id
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
    public function braintreeTransaction(User $user, SubscriptionPlan $plan, \Braintree\Gateway $gateway, $nonce)
    {
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
    public function braintreeVoid(\Braintree\Gateway $gateway, $transactionId)
    {
        $result = $gateway->transaction()->void($transactionId);
        return $result;
    }
}
