<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $caravans = Caravan::with('latestLocation')
            ->where('is_active', true)
            ->whereHas('latestLocation')
            ->get();

        return view('map.index', compact('caravans'));
    }

    public function show(Caravan $caravan)
    {
        $caravan->load('latestLocation');
        $locations = $caravan->locations()
            ->orderBy('tracked_at', 'desc')
            ->limit(500)
            ->get();

        return view('map.show', compact('caravan', 'locations'));
    }
}

