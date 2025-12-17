@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <a href="{{ route('caravans.index') }}" class="text-blue-500 hover:underline">← Back to Caravans</a>
                </div>
                
                <h2 class="text-2xl font-bold mb-4">{{ $caravan->name }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-semibold mb-2">Vehicle Information</h3>
                        <p><strong>Vehicle Number:</strong> {{ $caravan->vehicle_number }}</p>
                        @if($caravan->driver_name)
                            <p><strong>Driver:</strong> {{ $caravan->driver_name }}</p>
                        @endif
                        @if($caravan->driver_phone)
                            <p><strong>Driver Phone:</strong> {{ $caravan->driver_phone }}</p>
                        @endif
                        @if($caravan->description)
                            <p class="mt-2"><strong>Description:</strong> {{ $caravan->description }}</p>
                        @endif
                    </div>
                    
                    @if($caravan->latestLocation)
                        <div>
                            <h3 class="font-semibold mb-2">Current Location</h3>
                            <p><strong>Address:</strong> {{ $caravan->latestLocation->address ?? 'N/A' }}</p>
                            <p><strong>City:</strong> {{ $caravan->latestLocation->city ?? 'N/A' }}</p>
                            <p><strong>State:</strong> {{ $caravan->latestLocation->state ?? 'N/A' }}</p>
                            <p><strong>Coordinates:</strong> {{ number_format($caravan->latestLocation->latitude, 6) }}, {{ number_format($caravan->latestLocation->longitude, 6) }}</p>
                            <p><strong>Last Updated:</strong> {{ $caravan->latestLocation->tracked_at->format('Y-m-d H:i:s') }}</p>
                            @if($caravan->latestLocation->speed)
                                <p><strong>Speed:</strong> {{ number_format($caravan->latestLocation->speed, 2) }} km/h</p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mt-4">
                    <a href="{{ route('map.show', $caravan) }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        View on Map
                    </a>
                </div>

                <!-- Location History -->
                <div class="mt-8">
                    <h3 class="text-xl font-semibold mb-3">Recent Location History</h3>
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
@endsection

