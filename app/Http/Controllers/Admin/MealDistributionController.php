<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealDistribution;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MealDistributionController extends Controller
{
    private function distributionRoute(): string
    {
        return auth()->user()->role === 'gestionnaire'
            ? 'gestionnaire.meal-distributions'
            : 'admin.meal-distributions';
    }

    public function index(Request $request)
    {
        $query = MealDistribution::with([
            'reservation.student.schoolClass',
            'reservation.menu.dishes',
            'servedBy',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas(
                'reservation.student',
                function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('student_code', 'like', "%{$search}%");
                }
            );
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mealDistributions = $query
            ->latest()
            ->get();

        return view(
            'admin.meal-distributions.index',
            compact('mealDistributions')
        );
    }

    public function show(MealDistribution $mealDistribution)
    {
        $mealDistribution->load([
            'reservation.student.schoolClass',
            'reservation.menu.dishes',
            'servedBy',
        ]);

        return view(
            'admin.meal-distributions.show',
            compact('mealDistribution')
        );
    }

    public function create()
    {
        $reservations = Reservation::with([
            'student.schoolClass',
            'menu.dishes',
        ])
            ->where('status', 'reserved')
            ->orderBy('reserved_at', 'desc')
            ->get();

        return view(
            'admin.meal-distributions.create',
            compact('reservations')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => [
                'required',
                'exists:reservations,id',
            ],

            'status' => [
                'required',
                Rule::in([
                    'served',
                    'not_served',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $reservation = Reservation::with([
            'student',
            'menu',
        ])->findOrFail($validated['reservation_id']);

        if ($reservation->status !== 'reserved') {
            return back()
                ->withInput()
                ->withErrors([
                    'reservation_id' =>
                        'Only active reservations can receive a meal.',
                ]);
        }

        $alreadyRecorded = MealDistribution::where(
            'reservation_id',
            $reservation->id
        )->exists();

        if ($alreadyRecorded) {
            return back()
                ->withInput()
                ->withErrors([
                    'reservation_id' =>
                        'Meal presence has already been recorded for this reservation.',
                ]);
        }

        MealDistribution::create([
            'reservation_id' => $reservation->id,
            'menu_id' => $reservation->menu_id,
            'student_id' => $reservation->student_id,
            'status' => $validated['status'],
            'served_at' =>
                $validated['status'] === 'served'
                    ? now()
                    : null,
            'served_by' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route($this->distributionRoute() . '.index')
            ->with(
                'success',
                'Meal presence recorded successfully.'
            );
    }

    public function edit(MealDistribution $mealDistribution)
    {
        $mealDistribution->load([
            'reservation.student.schoolClass',
            'reservation.menu.dishes',
        ]);

        return view(
            'admin.meal-distributions.edit',
            compact('mealDistribution')
        );
    }

    public function update(
        Request $request,
        MealDistribution $mealDistribution
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'served',
                    'not_served',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $mealDistribution->update([
            'status' => $validated['status'],

            'served_at' =>
                $validated['status'] === 'served'
                    ? ($mealDistribution->served_at ?? now())
                    : null,

            'served_by' =>
                $validated['status'] === 'served'
                    ? ($mealDistribution->served_by ?? auth()->id())
                    : null,

            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route(
                $this->distributionRoute() . '.show',
                $mealDistribution
            )
            ->with(
                'success',
                'Meal presence updated successfully.'
            );
    }

    public function destroy(MealDistribution $mealDistribution)
    {
        $mealDistribution->delete();

        return redirect()
            ->route($this->distributionRoute() . '.index')
            ->with(
                'success',
                'Meal presence deleted successfully.'
            );
    }
}