<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        $reservations = $student
            ? $student->reservations()
                ->with('menu.dishes')
                ->latest('reserved_at')
                ->get()
            : collect();

        $todayMenus = Menu::with('dishes')
            ->whereDate('service_date', today())
            ->where('is_active', true)
            ->orderBy('service_time')
            ->get();

        return view(
            'eleve.dashboard',
            compact(
                'student',
                'reservations',
                'todayMenus'
            )
        );
    }

    public function reserve(Request $request)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403, 'Student profile not linked.');
        }

        $menu = Menu::with('dishes')
            ->whereDate('service_date', today())
            ->where('is_active', true)
            ->findOrFail($request->menu_id);

        /*
        |--------------------------------------------------------------------------
        | Prevent multiple reservations on the same day
        |--------------------------------------------------------------------------
        */

        if (
            $student->reservations()
                ->where('status', 'reserved')
                ->whereHas('menu', function ($query) use ($menu) {
                    $query->whereDate(
                        'service_date',
                        $menu->service_date
                    );
                })
                ->exists()
        ) {
            return redirect()
                ->route('eleve.dashboard')
                ->with(
                    'error',
                    'You already have a reservation for this day.'
                );
        }

        $student->reservations()->create([
            'menu_id' => $menu->id,
            'status' => 'reserved',
            'reserved_at' => now(),
        ]);

        return redirect()
            ->route('eleve.dashboard')
            ->with(
                'success',
                'Meal reserved successfully.'
            );
    }

    public function cancelReservation($reservation)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403, 'Student profile not linked.');
        }

        $reservation = $student->reservations()
            ->where('id', $reservation)
            ->where('status', 'reserved')
            ->firstOrFail();

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()
            ->route('eleve.dashboard')
            ->with(
                'success',
                'Meal reservation cancelled successfully.'
            );
    }
}