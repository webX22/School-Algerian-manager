<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/login',
        [AuthenticatedSessionController::class, 'create']
    )
        ->defaults('loginRole', 'admin')
        ->name('admin.login');

    Route::post(
        '/admin/login',
        [AuthenticatedSessionController::class, 'store']
    )
        ->defaults('loginRole', 'admin');


    /*
    |--------------------------------------------------------------------------
    | Gestionnaire Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/gestionnaire/login',
        [AuthenticatedSessionController::class, 'create']
    )
        ->defaults('loginRole', 'gestionnaire')
        ->name('gestionnaire.login');

    Route::post(
        '/gestionnaire/login',
        [AuthenticatedSessionController::class, 'store']
    )
        ->defaults('loginRole', 'gestionnaire');


    /*
    |--------------------------------------------------------------------------
    | Eleve Login
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/eleve/login',
        [AuthenticatedSessionController::class, 'create']
    )
        ->defaults('loginRole', 'eleve')
        ->name('eleve.login');

    Route::post(
        '/eleve/login',
        [AuthenticatedSessionController::class, 'store']
    )
        ->defaults('loginRole', 'eleve');


    /*
    |--------------------------------------------------------------------------
    | Registration
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/register',
        [RegisteredUserController::class, 'create']
    )
        ->name('register');

    Route::post(
        '/register',
        [RegisteredUserController::class, 'store']
    );


    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/forgot-password',
        [PasswordResetLinkController::class, 'create']
    )
        ->name('password.request');

    Route::post(
        '/forgot-password',
        [PasswordResetLinkController::class, 'store']
    );

    Route::get(
        '/reset-password/{token}',
        [NewPasswordController::class, 'create']
    )
        ->name('password.reset');

    Route::post(
        '/reset-password',
        [NewPasswordController::class, 'store']
    )
        ->name('password.store');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/verify-email',
        EmailVerificationPromptController::class
    )
        ->name('verification.notice');

    Route::get(
        '/verify-email/{id}/{hash}',
        VerifyEmailController::class
    )
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post(
        '/email/verification-notification',
        [EmailVerificationNotificationController::class, 'store']
    )
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get(
        '/confirm-password',
        [ConfirmablePasswordController::class, 'show']
    )
        ->name('password.confirm');

    Route::post(
        '/confirm-password',
        [ConfirmablePasswordController::class, 'store']
    );

    Route::put(
        '/password',
        [PasswordController::class, 'update']
    )
        ->name('password.update');

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )
        ->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )
        ->name('profile.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )
        ->name('profile.destroy');

    Route::post(
        '/logout',
        [AuthenticatedSessionController::class, 'destroy']
    )
        ->name('logout');
});
