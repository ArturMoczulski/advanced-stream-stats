<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;

class SubscriptionPlan extends Model
{
    use HasFactory;

    /**
     * Activates a subscription plan for a user
     * 
     * @param App\Models\User
     * @return boolean
     */
    public function activate(User $user, $start = null)
    {
        if ($user->hasActiveSubscription()) {
            return false;
        }

        if (!$start) {
            $start = Carbon::now();
        }

        $userSub = new UserSubscription;
        $userSub->start = $start;
        $userSub->end = $start->copy()->addMonths($this->billing_cycle);
        $userSub->user_id = $user->id;
        $userSub->subscription_plan_id = $this->id;
        $userSub->active = true;

        return $userSub->save();
    }

    public function userSubscriptions()
    {
        return $this->hasMany(userSubscription::class);
    }
}
