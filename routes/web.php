<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminTypeController;
use App\Http\Controllers\AdminReviewController;
use App\Models\User;
use App\Models\Review;
use App\Models\Type;

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

Route::get('/', [HomeController::class, 'index']);

Auth::routes((['verify' => true]));
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::bind('user', function ($value) {
    return User::where('name', $value)->first();
});

Route::get('{user}', [UserController::class, 'index']);
Route::delete('{user}', [UserController::class, 'destroy']);
Route::put('{user}/update', [UserController::class, 'update']);

Route::resource('review', ReviewController::class);
Route::delete('deleteImage/{image}', [ReviewController::class, 'deleteImage']);
Route::get('/review/display/{name}/{name2}', [HomeController::class, 'displayCarousel']);

Route::resource('admin/user', AdminUserController::class);
Route::resource('admin/type', AdminTypeController::class);
Route::resource('admin/review', AdminReviewController::class);

Route::fallback(function () {
    return view('errors.404');
});