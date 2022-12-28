<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubscriptionPlan;

class UserSubscription extends Model
{
    use HasFactory;

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        $this->belongsTo(SubscriptionPlan::class);
    }
}
