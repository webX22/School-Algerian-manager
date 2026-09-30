<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'gestionnaire' => redirect()->route('gestionnaire.dashboard'),
        'eleve' => redirect()->route('eleve.dashboard'),
        default => abort(403),
    };
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get(
        '/admin/dashboard',
        [\App\Http\Controllers\Admin\DashboardController::class, 'index']
    )->name('admin.dashboard');

    Route::resource(
        '/admin/users',
        \App\Http\Controllers\Admin\UserController::class
    );

    Route::resource(
        '/admin/classes',
        \App\Http\Controllers\Admin\SchoolClassController::class
    )
        ->names('classes')
        ->parameters(['classes' => 'schoolClass']);

    Route::resource(
        '/admin/students',
        \App\Http\Controllers\Admin\StudentController::class
    )
        ->names('students')
        ->parameters(['students' => 'student']);
});

/*
|--------------------------------------------------------------------------
| Admin + Gestionnaire Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,gestionnaire'])->group(function () {

    Route::resource(
        '/admin/dishes',
        \App\Http\Controllers\Admin\DishController::class
    )
        ->names('admin.dishes')
        ->parameters(['dishes' => 'dish']);

    Route::resource(
        '/admin/menus',
        \App\Http\Controllers\Admin\MenuController::class
    )
        ->names('admin.menus')
        ->parameters(['menus' => 'menu']);

    Route::resource(
        '/admin/meal-distributions',
        \App\Http\Controllers\Admin\MealDistributionController::class
    )
        ->names('admin.meal-distributions')
        ->parameters(['meal-distributions' => 'mealDistribution']);

    Route::resource(
        '/admin/reservations',
        \App\Http\Controllers\Admin\ReservationController::class
    )
        ->names('admin.reservations')
        ->parameters(['reservations' => 'reservation']);
});

/*
|--------------------------------------------------------------------------
| Gestionnaire Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:gestionnaire'])->group(function () {

    Route::get(
        '/gestionnaire/dashboard',
        [\App\Http\Controllers\Gestionnaire\DashboardController::class, 'index']
    )->name('gestionnaire.dashboard');

    Route::resource(
        '/gestionnaire/dishes',
        \App\Http\Controllers\Admin\DishController::class
    )
        ->names('gestionnaire.dishes')
        ->parameters(['dishes' => 'dish']);

    Route::resource(
        '/gestionnaire/menus',
        \App\Http\Controllers\Admin\MenuController::class
    )
        ->names('gestionnaire.menus')
        ->parameters(['menus' => 'menu']);

    Route::resource(
        '/gestionnaire/meal-distributions',
        \App\Http\Controllers\Admin\MealDistributionController::class
    )
        ->names('gestionnaire.meal-distributions')
        ->parameters(['meal-distributions' => 'mealDistribution']);

    Route::resource(
        '/gestionnaire/reservations',
        \App\Http\Controllers\Admin\ReservationController::class
    )
        ->names('gestionnaire.reservations')
        ->parameters(['reservations' => 'reservation']);
});

/*
|--------------------------------------------------------------------------
| Eleve Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:eleve'])->group(function () {

    Route::get(
        '/eleve/dashboard',
        function () {
            return view('eleve.dashboard');
        }
    )->name('eleve.dashboard');

    Route::get(
        '/eleve/menus',
        [\App\Http\Controllers\Eleve\MenuController::class, 'index']
    )->name('eleve.menus');

    Route::post(
        '/eleve/menus/{menu}/reserve',
        [\App\Http\Controllers\Eleve\ReservationController::class, 'store']
    )->name('eleve.reservations.store');

    Route::get(
        '/eleve/reservations',
        [\App\Http\Controllers\Eleve\ReservationController::class, 'index']
    )->name('eleve.reservations');

    Route::patch(
        '/eleve/reservations/{reservation}/cancel',
        [\App\Http\Controllers\Eleve\ReservationController::class, 'cancel']
    )->name('eleve.reservations.cancel');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';