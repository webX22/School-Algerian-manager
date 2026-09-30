<?php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\MealDistribution;
use App\Models\Menu;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Today's Reservations
        |--------------------------------------------------------------------------
        */

        $todayReservations = Reservation::whereDate(
            'reserved_at',
            today()
        )
            ->where('status', 'reserved')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Today's Served Meals
        |--------------------------------------------------------------------------
        */

        $todayServedMeals = MealDistribution::whereDate(
            'served_at',
            today()
        )
            ->where('status', 'served')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Today's Not Served Meals
        |--------------------------------------------------------------------------
        */

        $todayNotServedMeals = MealDistribution::whereDate(
            'served_at',
            today()
        )
            ->where('status', 'not_served')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Today's Meals To Serve
        |--------------------------------------------------------------------------
        */

        $todayMealsToServe =
            $todayServedMeals + $todayNotServedMeals;


        /*
        |--------------------------------------------------------------------------
        | Today's Menu
        |--------------------------------------------------------------------------
        */

        $todayMenu = Menu::with('dishes')
            ->whereDate('service_date', today())
            ->where('is_active', true)
            ->first();
        $operationsStatus = 'no_menu';

            if ($todayMenu) {
                $totalDistributions = $todayServedMeals + $todayNotServedMeals;

                if ($totalDistributions === 0) {
                    $operationsStatus = 'ready';
                } elseif ($totalDistributions < $todayReservations) {
                    $operationsStatus = 'in_progress';
                } else {
                    $operationsStatus = 'completed';
                }
            }
        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
        'gestionnaire.dashboard',
            compact(
        'todayReservations',
        'todayMealsToServe',
        'todayServedMeals',
        'todayNotServedMeals',
        'todayMenu',
        'operationsStatus'
    )
);
    }
}