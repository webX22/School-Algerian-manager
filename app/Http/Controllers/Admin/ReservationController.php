<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    private function reservationRoute(): string
    {
        return auth()->user()->role === 'gestionnaire'
            ? 'gestionnaire.reservations'
            : 'admin.reservations';
    }

    public function index(Request $request)
    {
        $query = Reservation::with([
            'student.schoolClass',
            'menu.dishes',
        ]);

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('menu_id')) {
            $query->where('menu_id', $request->menu_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query
            ->latest()
            ->get();

        $students = Student::where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $menus = Menu::with('dishes')
            ->where('is_active', true)
            ->orderBy('service_date', 'desc')
            ->get();

        return view(
            'admin.reservations.index',
            compact('reservations', 'students', 'menus')
        );
    }

    public function create()
    {
        $students = Student::with('schoolClass')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $menus = Menu::with('dishes')
            ->where('is_active', true)
            ->whereDate('service_date', '>=', today())
            ->orderBy('service_date')
            ->orderBy('service_time')
            ->get();

        return view(
            'admin.reservations.create',
            compact('students', 'menus')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'menu_id' => [
                'required',
                'exists:menus,id',
            ],
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);

        if (! $menu->is_active) {
            return back()
                ->withInput()
                ->withErrors([
                    'menu_id' =>
                        'This menu is not available for reservation.',
                ]);
        }

        if ($menu->service_date->lt(today())) {
            return back()
                ->withInput()
                ->withErrors([
                    'menu_id' =>
                        'This menu date has already passed.',
                ]);
        }

        $alreadyReserved = Reservation::where(
            'student_id',
            $validated['student_id']
        )
            ->where(
                'menu_id',
                $validated['menu_id']
            )
            ->where('status', 'reserved')
            ->exists();

        if ($alreadyReserved) {
            return back()
                ->withInput()
                ->withErrors([
                    'menu_id' =>
                        'This student has already reserved this menu.',
                ]);
        }

        Reservation::create([
            'student_id' => $validated['student_id'],
            'menu_id' => $validated['menu_id'],
            'status' => 'reserved',
            'reserved_at' => now(),
        ]);

        return redirect()
            ->route($this->reservationRoute() . '.index')
            ->with(
                'success',
                'Meal reservation created successfully.'
            );
    }

    public function show(Reservation $reservation)
    {
        $reservation->load([
            'student.schoolClass',
            'menu.dishes',
        ]);

        return view(
            'admin.reservations.show',
            compact('reservation')
        );
    }

    public function edit(Reservation $reservation)
    {
        $students = Student::with('schoolClass')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $menus = Menu::with('dishes')
            ->where('is_active', true)
            ->orderBy('service_date')
            ->orderBy('service_time')
            ->get();

        return view(
            'admin.reservations.edit',
            compact('reservation', 'students', 'menus')
        );
    }

    public function update(
        Request $request,
        Reservation $reservation
    ) {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
            ],

            'menu_id' => [
                'required',
                'exists:menus,id',
            ],

            'status' => [
                'required',
                Rule::in([
                    'reserved',
                    'cancelled',
                ]),
            ],
        ]);

        $duplicate = Reservation::where(
            'student_id',
            $validated['student_id']
        )
            ->where(
                'menu_id',
                $validated['menu_id']
            )
            ->where(
                'id',
                '!=',
                $reservation->id
            )
            ->where('status', 'reserved')
            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'menu_id' =>
                        'This student already has an active reservation for this menu.',
                ]);
        }

        $validated['cancelled_at'] =
            $validated['status'] === 'cancelled'
                ? ($reservation->cancelled_at ?? now())
                : null;

        $reservation->update($validated);

        return redirect()
            ->route($this->reservationRoute() . '.index')
            ->with(
                'success',
                'Reservation updated successfully.'
            );
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->mealDistribution()->exists()) {
            return redirect()
                ->route($this->reservationRoute() . '.index')
                ->with(
                    'error',
                    'This reservation cannot be deleted because meal presence is already recorded for it.'
                );
        }

        $reservation->delete();

        return redirect()
            ->route($this->reservationRoute() . '.index')
            ->with(
                'success',
                'Reservation deleted successfully.'
            );
    }
}