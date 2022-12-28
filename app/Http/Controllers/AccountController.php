<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    }

}
