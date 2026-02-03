<?php

use App\Events\MembershipHasExpired;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\TransactionController;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){
    return view('movies.index');
})->middleware(['auth', 'check.device.limit'])->name('home');

Route::post('/logout', function(Request $request){
    return app(AuthenticatedSessionController::class)->destroy($request);
})->name('logout')->middleware(['auth', 'logout.device']);

Route::get('/home', [MovieController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'all'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])->name('subscribe.plans');
Route::get('/subscribe/plan/{plan}', [SubscribeController::class, 'checkoutPlan'])->name('subscribe.checkout');
Route::post('/subscribe/checkout', [SubscribeController::class, 'processCheckout'])->name('subscribe.process');
Route::get('/subscribe/success', [SubscribeController::class, 'showSuccess'])->name('subscribe.success');

Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');


// Route::get('/text-expired', function () {
//     $membership = Membership::find(8);
//     event(new MembershipHasExpired($membership));

//     return 'Event Fired';
// });

Route::get('/test-expired', function () {

    $user = Auth::user(); // user yang sedang login

    if (! $user) {
        return 'User not logged in';
    }

    $membership = Membership::where('user_id', $user->id)
        ->where('active', true)
        ->first();

    if (! $membership) {
        return 'No active membership for this user';
    }

    event(new MembershipHasExpired($membership));

    return 'Event Fired for user ID ' . $user->id;
});