<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Caravan;
use App\Models\CaravanLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function update(Request $request, Caravan $caravan)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $location = CaravanLocation::create([
            'caravan_id' => $caravan->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'speed' => $request->speed,
            'heading' => $request->heading,
            'tracked_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'location' => $location,
        ], 201);
    }

    public function getLatest(Caravan $caravan)
    {
        $location = $caravan->latestLocation;

        if (!$location) {
            return response()->json(['message' => 'No location found'], 404);
        }

        return response()->json([
            'caravan' => [
                'id' => $caravan->id,
                'name' => $caravan->name,
                'vehicle_number' => $caravan->vehicle_number,
            ],
            'location' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'address' => $location->address,
                'city' => $location->city,
                'state' => $location->state,
                'speed' => $location->speed,
                'heading' => $location->heading,
                'tracked_at' => $location->tracked_at->toIso8601String(),
            ],
        ]);
    }

    public function getAll()
    {
        $caravans = Caravan::with('latestLocation')
            ->where('is_active', true)
            ->whereHas('latestLocation')
            ->get();

        $data = $caravans->map(function ($caravan) {
            $location = $caravan->latestLocation;
            return [
                'id' => $caravan->id,
                'name' => $caravan->name,
                'vehicle_number' => $caravan->vehicle_number,
                'latitude' => $location->latitude ?? null,
                'longitude' => $location->longitude ?? null,
                'address' => $location->address ?? null,
                'city' => $location->city ?? null,
                'state' => $location->state ?? null,
                'speed' => $location->speed ?? null,
                'heading' => $location->heading ?? null,
                'tracked_at' => $location->tracked_at->toIso8601String() ?? null,
            ];
        });

        return response()->json($data);
    }

    public function getHistory(Caravan $caravan, Request $request)
    {
        $limit = $request->get('limit', 100);
        
        $locations = $caravan->locations()
            ->orderBy('tracked_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'caravan' => [
                'id' => $caravan->id,
                'name' => $caravan->name,
                'vehicle_number' => $caravan->vehicle_number,
            ],
            'locations' => $locations->map(function ($location) {
                return [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'address' => $location->address,
                    'city' => $location->city,
                    'state' => $location->state,
                    'speed' => $location->speed,
                    'heading' => $location->heading,
                    'tracked_at' => $location->tracked_at->toIso8601String(),
                ];
            }),
        ]);
    }
}

