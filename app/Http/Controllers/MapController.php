<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\Destination;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $caravans = Caravan::with('latestLocation')
            ->where('is_active', true)
            ->whereHas('latestLocation')
            ->get();

        $destinations = Destination::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('map.index', compact('caravans', 'destinations'));
    }

    public function show(Caravan $caravan)
    {
        $caravan->load('latestLocation');
        $locations = $caravan->locations()
            ->orderBy('tracked_at', 'desc')
            ->limit(500)
            ->get();

        $destinations = Destination::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('map.show', compact('caravan', 'locations', 'destinations'));
    }
}

