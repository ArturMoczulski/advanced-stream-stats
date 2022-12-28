<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_purchase_subscription_page_is_displayed()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/purchase');

        $response->assertOk();
    }

}
