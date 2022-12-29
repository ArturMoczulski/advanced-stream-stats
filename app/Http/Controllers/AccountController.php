<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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

        $sub->renew = false;
        $result = $sub->save();

        return Redirect::route('dashboard')
            ->with('success', "Sorry to see you go! Your subscription will not be renewed. You can continue using your account until your current plan expires on " . $sub->end);
    }

}
