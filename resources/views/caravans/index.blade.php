@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">All Caravans</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($caravans as $caravan)
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold mb-2">{{ $caravan->name }}</h3>
                            <p class="text-gray-600 mb-2">Vehicle: {{ $caravan->vehicle_number }}</p>
                            
                            @if($caravan->description)
                                <p class="text-sm text-gray-500 mb-3">{{ $caravan->description }}</p>
                            @endif

                            @if($caravan->driver_name)
                                <p class="text-sm mb-1"><strong>Driver:</strong> {{ $caravan->driver_name }}</p>
                            @endif

                            @if($caravan->latestLocation)
                                <div class="mt-4 p-3 bg-blue-50 rounded">
                                    <p class="text-sm"><strong>Current Location:</strong></p>
                                    <p class="text-sm">{{ $caravan->latestLocation->city ?? 'N/A' }}, {{ $caravan->latestLocation->state ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Updated: {{ $caravan->latestLocation->tracked_at->diffForHumans() }}
                                    </p>
                                </div>
                                <a href="{{ route('map.show', $caravan) }}" class="mt-3 inline-block text-blue-500 hover:underline text-sm">
                                    View on Map →
                                </a>
                            @else
                                <div class="mt-4 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-500">No location data available</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-3 text-center text-gray-500 py-8">
                            No caravans found
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

