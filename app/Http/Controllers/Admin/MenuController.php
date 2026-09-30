<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private function menuRoute(): string
    {
        return auth()->user()->role === 'gestionnaire'
            ? 'gestionnaire.menus'
            : 'admin.menus';
    }

    public function index(Request $request)
    {
        $query = Menu::with('dishes');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('service_date', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('dish_id')) {
            $query->whereHas('dishes', function ($q) use ($request) {
                $q->where('dishes.id', $request->dish_id);
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'is_active',
                $request->status === 'active'
            );
        }

        $menus = $query
            ->orderBy('service_date', 'desc')
            ->orderBy('service_time')
            ->get();

        $dishes = Dish::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.menus.index',
            compact('menus', 'dishes')
        );
    }

    public function create()
    {
        $dishes = Dish::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.menus.create',
            compact('dishes')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_date' => ['required', 'date'],
            'service_time' => ['nullable', 'date_format:H:i'],
            'planned_quantity' => ['required', 'integer', 'min:0'],
            'dish_ids' => ['required', 'array', 'min:1'],
            'dish_ids.*' => ['integer', 'exists:dishes,id'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $menu = Menu::create([
            'service_date' => $validated['service_date'],
            'service_time' => $validated['service_time'] ?? null,
            'planned_quantity' => $validated['planned_quantity'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        $menu->dishes()->sync($validated['dish_ids']);

        return redirect()
            ->route($this->menuRoute() . '.index')
            ->with(
                'success',
                'Daily menu created successfully.'
            );
    }

    public function show(Menu $menu)
    {
        $menu->load('dishes');

        return view(
            'admin.menus.show',
            compact('menu')
        );
    }

    public function edit(Menu $menu)
    {
        $menu->load('dishes');

        $dishes = Dish::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.menus.edit',
            compact('menu', 'dishes')
        );
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'service_date' => ['required', 'date'],
            'service_time' => ['nullable', 'date_format:H:i'],
            'planned_quantity' => ['required', 'integer', 'min:0'],
            'dish_ids' => ['required', 'array', 'min:1'],
            'dish_ids.*' => ['integer', 'exists:dishes,id'],
            'notes' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $menu->update([
            'service_date' => $validated['service_date'],
            'service_time' => $validated['service_time'] ?? null,
            'planned_quantity' => $validated['planned_quantity'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        $menu->dishes()->sync($validated['dish_ids']);

        return redirect()
            ->route($this->menuRoute() . '.index')
            ->with(
                'success',
                'Daily menu updated successfully.'
            );
    }

    public function destroy(Menu $menu)
    {
        /*
        |--------------------------------------------------------------------------
        | Protect historical menu data
        |--------------------------------------------------------------------------
        */

        if ($menu->mealDistributions()->exists()) {
            return redirect()
                ->route($this->menuRoute() . '.index')
                ->with(
                    'error',
                    'This menu cannot be deleted because meal distribution records already exist for it.'
                );
        }

        if ($menu->reservations()->exists()) {
            return redirect()
                ->route($this->menuRoute() . '.index')
                ->with(
                    'error',
                    'This menu cannot be deleted because reservations already exist for it.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Safe deletion
        |--------------------------------------------------------------------------
        */

        $menu->dishes()->detach();

        $menu->delete();

        return redirect()
            ->route($this->menuRoute() . '.index')
            ->with(
                'success',
                'Daily menu deleted successfully.'
            );
    }
}