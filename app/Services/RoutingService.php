<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RoutingService
{
    /**
     * Calculate distance and duration between two points using OSRM (Open Source Routing Machine)
     * This is free and doesn't require an API key
     */
    public function getRouteInfo($lat1, $lon1, $lat2, $lon2)
    {
        $cacheKey = "route_{$lat1}_{$lon1}_{$lat2}_{$lon2}";
        
        return Cache::remember($cacheKey, 3600, function () use ($lat1, $lon1, $lat2, $lon2) {
            try {
                // Using OSRM routing service (free, no API key needed)
                $url = "http://router.project-osrm.org/route/v1/driving/{$lon1},{$lat1};{$lon2},{$lat2}?overview=false&alternatives=false&steps=false";
                
                $response = Http::timeout(5)->get($url);
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data['routes']) && count($data['routes']) > 0) {
                        $route = $data['routes'][0];
                        $distance = $route['distance'] / 1000; // Convert to km
                        $duration = $route['duration'] / 60; // Convert to minutes
                        
                        return [
                            'distance' => round($distance, 2),
                            'duration' => round($duration, 1),
                            'duration_hours' => floor($duration / 60),
                            'duration_minutes' => round($duration % 60),
                            'status' => 'success'
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Fallback to straight-line distance calculation
                return $this->calculateStraightLineDistance($lat1, $lon1, $lat2, $lon2);
            }
            
            // Fallback if API fails
            return $this->calculateStraightLineDistance($lat1, $lon1, $lat2, $lon2);
        });
    }

    /**
     * Calculate straight-line distance (Haversine formula)
     * This is a fallback when routing API is unavailable
     */
    private function calculateStraightLineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;
        
        // Estimate duration based on average speed (50 km/h)
        $avgSpeed = 50; // km/h
        $duration = ($distance / $avgSpeed) * 60; // minutes
        
        return [
            'distance' => round($distance, 2),
            'duration' => round($duration, 1),
            'duration_hours' => floor($duration / 60),
            'duration_minutes' => round($duration % 60),
            'status' => 'estimated',
            'note' => 'Straight-line distance estimate'
        ];
    }

    /**
     * Get route information for multiple destinations
     */
    public function getRouteToDestinations($currentLat, $currentLon, $destinations)
    {
        $results = [];
        
        foreach ($destinations as $destination) {
            $routeInfo = $this->getRouteInfo(
                $currentLat,
                $currentLon,
                $destination->latitude,
                $destination->longitude
            );
            
            $results[$destination->id] = array_merge($routeInfo, [
                'destination_id' => $destination->id,
                'destination_name' => $destination->name,
            ]);
        }
        
        return $results;
    }
}

