<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $reservations = Reservation::with([
            'menu.dishes',
        ])
            ->where('student_id', $student->id)
            ->orderByDesc('reserved_at')
            ->get();

        return view(
            'eleve.reservations',
            compact('reservations')
        );
    }

    public function store(Menu $menu)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Check menu availability
        |--------------------------------------------------------------------------
        */

        if (! $menu->is_active) {
            return back()->with(
                'error',
                'This menu is not currently available.'
            );
        }

        if ($menu->service_date->lt(today())) {
            return back()->with(
                'error',
                'This menu is in the past and cannot be reserved.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check existing reservation
        |--------------------------------------------------------------------------
        */

        $existingReservation = Reservation::where(
            'student_id',
            $student->id
        )
            ->where(
                'menu_id',
                $menu->id
            )
            ->first();

        if ($existingReservation) {

            if ($existingReservation->status === 'reserved') {
                return back()->with(
                    'error',
                    'You have already reserved this menu.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Re-activate a cancelled reservation
            |--------------------------------------------------------------------------
            */

            $existingReservation->update([
                'status' => 'reserved',
                'reserved_at' => now(),
                'cancelled_at' => null,
            ]);

            return redirect()
                ->route('eleve.reservations')
                ->with(
                    'success',
                    'Your reservation has been made successfully.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create reservation
        |--------------------------------------------------------------------------
        */

        Reservation::create([
            'student_id' => $student->id,
            'menu_id' => $menu->id,
            'status' => 'reserved',
            'reserved_at' => now(),
            'cancelled_at' => null,
        ]);

        return redirect()
            ->route('eleve.reservations')
            ->with(
                'success',
                'Your reservation has been made successfully.'
            );
    }

    public function cancel(Reservation $reservation)
    {
        $student = auth()->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        if ($reservation->student_id !== $student->id) {
            abort(403);
        }

        if ($reservation->status !== 'reserved') {
            return back()->with(
                'error',
                'This reservation is already cancelled.'
            );
        }

        if ($reservation->menu->service_date->lt(today())) {
            return back()->with(
                'error',
                'This reservation can no longer be cancelled.'
            );
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with(
            'success',
            'Your reservation has been cancelled successfully.'
        );
    }
}