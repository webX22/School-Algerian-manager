<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('dishes')
            ->where('is_active', true)
            ->whereDate('service_date', '>=', today())
            ->orderBy('service_date')
            ->orderBy('service_time')
            ->get();

        return view(
            'eleve.menus',
            compact('menus')
        );
    }
}