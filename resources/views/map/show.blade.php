@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <a href="{{ route('map.index') }}" class="text-blue-500 hover:underline">← Back to Map</a>
                </div>
                
                <h2 class="text-2xl font-bold mb-2">{{ $caravan->name }}</h2>
                <p class="text-gray-600 mb-4">Vehicle Number: {{ $caravan->vehicle_number }}</p>
                
                @if($caravan->latestLocation)
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold mb-2">Current Location</h3>
                        <p><strong>Address:</strong> {{ $caravan->latestLocation->address ?? 'N/A' }}</p>
                        <p><strong>City:</strong> {{ $caravan->latestLocation->city ?? 'N/A' }}</p>
                        <p><strong>State:</strong> {{ $caravan->latestLocation->state ?? 'N/A' }}</p>
                        <p><strong>Last Updated:</strong> {{ $caravan->latestLocation->tracked_at->format('Y-m-d H:i:s') }}</p>
                        @if($caravan->latestLocation->speed)
                            <p><strong>Speed:</strong> {{ number_format($caravan->latestLocation->speed, 2) }} km/h</p>
                        @endif
                    </div>
                @endif

                <!-- Map Controls -->
                <div class="mb-4 flex flex-wrap gap-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="showDestinations" checked onchange="toggleDestinations()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Show Destinations</span>
                    </label>
                </div>

                <!-- Map Container -->
                <div id="map" style="height: 600px; width: 100%;"></div>

                <!-- Location History -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-3">Location History</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coordinates</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Speed</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($locations as $location)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $location->tracked_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $location->address ?? 'N/A' }}<br>
                                            <span class="text-gray-500">{{ $location->city ?? '' }}, {{ $location->state ?? '' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($location->latitude, 6) }}, {{ number_format($location->longitude, 6) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $location->speed ? number_format($location->speed, 2) . ' km/h' : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No location history available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let map;
    let polyline;
    let updateInterval;
    let destinationMarkers = [];

    function initMap() {
        @if($caravan->latestLocation)
            const centerLat = {{ $caravan->latestLocation->latitude }};
            const centerLng = {{ $caravan->latestLocation->longitude }};
        @else
            const centerLat = 10.5276;
            const centerLng = 76.2144;
        @endif

        map = L.map('map').setView([centerLat, centerLng], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add destination markers
        @foreach($destinations as $destination)
            addDestinationMarker({{ $destination->id }}, {{ $destination->latitude }}, {{ $destination->longitude }}, '{{ addslashes($destination->name) }}', '{{ addslashes($destination->city ?? '') }}', '{{ addslashes($destination->state ?? '') }}', {{ $destination->order }});
        @endforeach

        // Add route polyline
        const routeCoordinates = [
            @foreach($locations->reverse() as $location)
                [{{ $location->latitude }}, {{ $location->longitude }}],
            @endforeach
        ];

        if (routeCoordinates.length > 0) {
            polyline = L.polyline(routeCoordinates, {
                color: '#4F46E5',
                weight: 4,
                opacity: 0.7
            }).addTo(map);

            // Fit bounds to include both route and destinations
            const bounds = polyline.getBounds();
            destinationMarkers.forEach(marker => {
                bounds.extend(marker.getLatLng());
            });
            map.fitBounds(bounds);
        } else {
            // If no route, fit to destinations
            if (destinationMarkers.length > 0) {
                const group = new L.featureGroup(destinationMarkers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        }
    }

    function addDestinationMarker(destinationId, lat, lng, name, city, state, order) {
        // Custom icon for destinations - red pin
        const icon = L.divIcon({
            className: 'destination-marker',
            html: `<div style="background-color: #EF4444; color: white; border-radius: 50% 50% 50% 0; width: 25px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3); transform: rotate(-45deg);">
                <span style="transform: rotate(45deg); font-size: 12px;">📍</span>
            </div>`,
            iconSize: [25, 30],
            iconAnchor: [12, 30]
        });

        const marker = L.marker([lat, lng], { icon: icon }).addTo(map);
        
        const locationText = city && state ? `${city}, ${state}` : (city || state || '');
        marker.bindPopup(`
            <div>
                <h3 class="font-bold text-red-600">📍 ${name}</h3>
                ${locationText ? `<p class="text-sm text-gray-600">${locationText}</p>` : ''}
                ${order ? `<p class="text-xs text-gray-500">Order: ${order}</p>` : ''}
            </div>
        `);

        destinationMarkers.push(marker);
    }

    function toggleDestinations() {
        const show = document.getElementById('showDestinations').checked;
        destinationMarkers.forEach(marker => {
            if (show) {
                marker.addTo(map);
            } else {
                map.removeLayer(marker);
            }
        });
    }

        // Add markers for each location point
        @foreach($locations as $location)
            @if($loop->first)
                // Latest location - different marker
                const latestIcon = L.divIcon({
                    className: 'caravan-marker',
                    html: `<div style="background-color: #4F46E5; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">🚐</div>`,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });
                L.marker([{{ $location->latitude }}, {{ $location->longitude }}], { icon: latestIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div>
                            <h3 class="font-bold">Current Location</h3>
                            <p class="text-sm">{{ $location->address ?? 'N/A' }}</p>
                            <p class="text-sm">{{ $location->city ?? '' }}, {{ $location->state ?? '' }}</p>
                            <p class="text-xs text-gray-500">{{ $location->tracked_at->format('Y-m-d H:i:s') }}</p>
                        </div>
                    `);
            @else
                // Historical locations - smaller markers
                L.circleMarker([{{ $location->latitude }}, {{ $location->longitude }}], {
                    radius: 5,
                    fillColor: '#4F46E5',
                    color: '#fff',
                    weight: 2,
                    opacity: 0.7,
                    fillOpacity: 0.7
                }).addTo(map);
            @endif
        @endforeach
    }

    function updateLocation() {
        fetch(`/api/caravans/{{ $caravan->id }}/location`)
            .then(response => response.json())
            .then(data => {
                if (data.location) {
                    // Update map if location changed
                    const lat = parseFloat(data.location.latitude);
                    const lng = parseFloat(data.location.longitude);
                    
                    // You can update the marker position here
                    // For now, we'll just reload the page every 30 seconds
                }
            })
            .catch(error => console.error('Error updating location:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Update location every 30 seconds
        updateInterval = setInterval(updateLocation, 30000);
    });

    window.addEventListener('beforeunload', function() {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
    });
</script>
@endpush
@endsection

