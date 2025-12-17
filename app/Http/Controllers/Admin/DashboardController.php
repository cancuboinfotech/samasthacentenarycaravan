<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caravan;
use App\Models\Destination;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $caravansCount = Caravan::where('is_active', true)->count();
        $destinationsCount = Destination::where('is_active', true)->count();
        $recentCaravans = Caravan::with('latestLocation')
            ->where('is_active', true)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('caravansCount', 'destinationsCount', 'recentCaravans'));
    }
}

