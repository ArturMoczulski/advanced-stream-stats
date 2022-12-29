<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $user = Auth::user();

    if ($user) {

        if ($user->hasActiveSubscription()) {
            return Redirect::route('dashboard');
        } else {
            return Redirect::route('subscription_plans.index');
        }

    } else {
        return Redirect::route('register');
    }

});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/account/billing_plan', [AccountController::class, 'billingPlan'])->name('account.billing_plan');
    Route::get('/account/cancel', [AccountController::class, 'cancel'])->name('account.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/subscription_plans/{id}/purchase', [SubscriptionPlanController::class, 'purchase'])->name('subscription_plans.purchase');
    Route::get('/subscription_plans', [SubscriptionPlanController::class, 'index'])->name('subscription_plans.index');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.checkout');
});

require __DIR__.'/auth.php';
