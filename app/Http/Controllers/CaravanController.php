<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use Illuminate\Http\Request;

class CaravanController extends Controller
{
    public function index()
    {
        $caravans = Caravan::with('latestLocation')->where('is_active', true)->get();
        return view('caravans.index', compact('caravans'));
    }

    public function show(Caravan $caravan)
    {
        $caravan->load('latestLocation');
        $locations = $caravan->locations()->orderBy('tracked_at', 'desc')->limit(100)->get();
        
        return view('caravans.show', compact('caravan', 'locations'));
    }
}

