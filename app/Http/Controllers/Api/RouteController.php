<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Caravan;
use App\Models\Destination;
use App\Services\RoutingService;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    protected $routingService;

    public function __construct(RoutingService $routingService)
    {
        $this->routingService = $routingService;
    }

    public function getCaravanToDestinations(Caravan $caravan)
    {
        $caravan->load('latestLocation');
        
        if (!$caravan->latestLocation) {
            return response()->json([
                'error' => 'Caravan has no location data'
            ], 404);
        }

        $destinations = Destination::where('is_active', true)
            ->orderBy('order')
            ->get();

        $routeInfo = $this->routingService->getRouteToDestinations(
            $caravan->latestLocation->latitude,
            $caravan->latestLocation->longitude,
            $destinations
        );

        return response()->json([
            'caravan' => [
                'id' => $caravan->id,
                'name' => $caravan->name,
                'current_location' => [
                    'latitude' => $caravan->latestLocation->latitude,
                    'longitude' => $caravan->latestLocation->longitude,
                    'address' => $caravan->latestLocation->address,
                    'city' => $caravan->latestLocation->city,
                    'state' => $caravan->latestLocation->state,
                ]
            ],
            'destinations' => $routeInfo
        ]);
    }

    public function getRouteBetweenPoints(Request $request)
    {
        $request->validate([
            'lat1' => 'required|numeric',
            'lon1' => 'required|numeric',
            'lat2' => 'required|numeric',
            'lon2' => 'required|numeric',
        ]);

        $routeInfo = $this->routingService->getRouteInfo(
            $request->lat1,
            $request->lon1,
            $request->lat2,
            $request->lon2
        );

        return response()->json($routeInfo);
    }
}

