<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_users_active_subscription_can_be_retrieved()
    {
        $plan = SubscriptionPlan::factory()->create();
        $user = User::factory()->create();

        UserSubscription::factory()->active($user, $plan);

        $this->assertInstanceOf(
            UserSubscription::class, 
            $user->activeSubscription()
        );
    }
}
