<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    /**
     * Display the user's current billing plan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function billingPlan(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return Redirect::route('subscription_plans.index');
        }

        return Inertia::render('Account/BillingPlan', [
            'subscriptionPlan' => $user->activeSubscription()->subscriptionPlan,
            'userSubscription' => $user->activeSubscription()
        ]);
    }

    /**
     * Cancel user's sub
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $sub = $user->activeSubscription();

        DB::beginTransaction();

        $sub->renew = false;
        $result = $sub->save();

        $gateway = new \Braintree\Gateway([
            'environment' => config('app.braintree.env'),
            'merchantId' => config('app.braintree.merchantId'),
            'publicKey' => config('app.braintree.publicKey'),
            'privateKey' => config('app.braintree.privateKey')
        ]);

        $result = $gateway->subscription()->cancel($sub->braintree_subscription_id);
        if (!$result->success) {
            DB::rollBack();
            return Redirect::route('account.billing_plans')
                ->with('error', "Failed to cancel the subscription. Please contact support" . $sub->end);
        }

        DB::commit();
        return Redirect::route('dashboard')
            ->with('success', "Sorry to see you go! Your subscription will not be renewed. You can continue using your account until your current plan expires on " . $sub->end);
    }

}
