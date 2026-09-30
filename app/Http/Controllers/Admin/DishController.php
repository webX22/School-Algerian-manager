<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DishController extends Controller
{
    /**
     * Get the correct dish route for the logged-in user.
     */
    private function dishRoute(): string
    {
        return auth()->user()->role === 'gestionnaire'
            ? 'gestionnaire.dishes'
            : 'admin.dishes';
    }

    /**
     * Display a listing of the dishes.
     */
    public function index(Request $request)
    {
        $query = Dish::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('dish_type')) {
            $query->where('dish_type', $request->dish_type);
        }

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        $dishes = $query
            ->latest()
            ->get();

        return view(
            'admin.dishes.index',
            compact('dishes')
        );
    }

    /**
     * Show the form for creating a new dish.
     */
    public function create()
    {
        return view('admin.dishes.create');
    }

    /**
     * Store a newly created dish in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'dish_type' => [
                'required',
                Rule::in([
                    'appetizer',
                    'main_course',
                    'dessert',
                ]),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        Dish::create($validated);

        return redirect()
            ->route($this->dishRoute() . '.index')
            ->with(
                'success',
                'Dish created successfully.'
            );
    }

    /**
     * Display the specified dish.
     */
    public function show(Dish $dish)
    {
        $dish->load('menus');

        return view(
            'admin.dishes.show',
            compact('dish')
        );
    }

    /**
     * Show the form for editing the specified dish.
     */
    public function edit(Dish $dish)
    {
        return view(
            'admin.dishes.edit',
            compact('dish')
        );
    }

    /**
     * Update the specified dish in storage.
     */
    public function update(
        Request $request,
        Dish $dish
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'dish_type' => [
                'required',
                Rule::in([
                    'appetizer',
                    'main_course',
                    'dessert',
                ]),
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        $dish->update($validated);

        return redirect()
            ->route($this->dishRoute() . '.index')
            ->with(
                'success',
                'Dish updated successfully.'
            );
    }

    /**
     * Remove the specified dish from storage.
     */
    public function destroy(Dish $dish)
    {
        if ($dish->menus()->exists()) {
            return redirect()
                ->route($this->dishRoute() . '.index')
                ->with(
                    'error',
                    'This dish cannot be deleted because it is used by a menu.'
                );
        }

        $dish->delete();

        return redirect()
            ->route($this->dishRoute() . '.index')
            ->with(
                'success',
                'Dish deleted successfully.'
            );
    }
}