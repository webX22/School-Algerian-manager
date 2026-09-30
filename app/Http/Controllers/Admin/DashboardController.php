<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealDistribution;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalStudents = User::where('role', 'eleve')->count();

        $totalGestionnaires = User::where('role', 'gestionnaire')->count();

        $totalAdministrators = User::where('role', 'admin')->count();


        /*
        |--------------------------------------------------------------------------
        | Today's Meal Statistics
        |--------------------------------------------------------------------------
        */

        $todayReservations = Reservation::whereDate(
            'reserved_at',
            today()
        )
            ->where('status', 'reserved')
            ->count();

        $todayServedMeals = MealDistribution::whereDate(
            'served_at',
            today()
        )
            ->where('status', 'served')
            ->count();

        $todayNotServedMeals = MealDistribution::whereDate(
            'served_at',
            today()
        )
            ->where('status', 'not_served')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Weekly Reservation Statistics
        |--------------------------------------------------------------------------
        */

        $weeklyReservations = Reservation::whereBetween(
            'reserved_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )
            ->where('status', 'reserved')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStudents',
            'totalGestionnaires',
            'totalAdministrators',
            'todayReservations',
            'todayServedMeals',
            'todayNotServedMeals',
            'weeklyReservations'
        ));
    }
}