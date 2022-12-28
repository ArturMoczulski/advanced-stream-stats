<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserSubscription;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get user's subscription records
     */
    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    
    /**
     * Get user's active subscription
     * 
     * @return App\Models\UserSubscription|null
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('active', true)
            ->where('end', '>', Carbon::now())
            ->first();
    }

    /**
     * Does this user have an active subscription
     * 
     * @return boolean
     */
    public function hasActiveSubscription()
    {
        return $this->activeSubscription() != null;
    }
}
