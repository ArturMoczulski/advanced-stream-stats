<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSubscription>
 */
class UserSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
    }

    public function active(User $user, SubscriptionPlan $plan)
    {
        $start = Carbon::now();
        $end = Carbon::now()->addMonths($plan->billing_cycle);

        return [
            'start' => $start,
            'end' => $end,
            'user_id' => $user->id,
            'active' => true
        ];
    }
}
