@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="mb-6">
                <a href="{{ route('admin.destinations.index') }}" class="text-blue-500 hover:underline">← Back to Destinations</a>
            </div>

            <h2 class="text-2xl font-bold mb-6">Import Destinations</h2>

            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-semibold mb-2">Google Maps Import Instructions:</h3>
                <ol class="list-decimal list-inside space-y-2 text-sm">
                    <li>Open your Google Maps: <a href="https://www.google.com/maps/d/u/0/edit?mid=1vdYRgLz992EMqWi2e0q6tfMfMVZgqOc&usp=sharing" target="_blank" class="text-blue-600 hover:underline">View Map</a></li>
                    <li>For each destination, note down: Name, Latitude, Longitude, Address, City, State</li>
                    <li>You can get coordinates by clicking on a location in Google Maps</li>
                    <li>Use the format below to import destinations</li>
                </ol>
            </div>

            <form action="{{ route('admin.destinations.import') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="import_type" class="block text-sm font-medium text-gray-700 mb-2">Import Format</label>
                    <select name="import_type" id="import_type" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            onchange="updateFormatExample()">
                        <option value="coordinates">Coordinates (Simple Format)</option>
                        <option value="json">JSON Format</option>
                        <option value="csv">CSV Format</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="import_data" class="block text-sm font-medium text-gray-700 mb-2">Import Data</label>
                    <textarea name="import_data" id="import_data" rows="15" required
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm @error('import_data') border-red-500 @enderror"
                              placeholder="Paste your destination data here..."></textarea>
                    @error('import_data')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="format_example" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold mb-2">Format Example (Coordinates):</h4>
                    <pre class="text-sm text-gray-700 font-mono">Thiruvananthapuram, 8.5241, 76.9366, MG Road, Thiruvananthapuram, Kerala
Kochi, 9.9312, 76.2673, Marine Drive, Kochi, Kerala
Kozhikode, 11.2588, 75.7804, Beach Road, Kozhikode, Kerala</pre>
                    <p class="text-xs text-gray-600 mt-2">Format: Name, Latitude, Longitude, Address, City, State</p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Import Destinations
                    </button>
                    <a href="{{ route('admin.destinations.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>

            <div class="mt-8 p-4 bg-yellow-50 rounded-lg">
                <h4 class="font-semibold mb-2">Quick Add from Google Maps:</h4>
                <p class="text-sm text-gray-700 mb-4">
                    To get coordinates from Google Maps:
                </p>
                <ol class="list-decimal list-inside space-y-1 text-sm text-gray-700">
                    <li>Right-click on a location in Google Maps</li>
                    <li>Click on the coordinates that appear</li>
                    <li>Copy the latitude and longitude</li>
                    <li>Enter them in the format: Name, Latitude, Longitude, Address, City, State</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFormatExample() {
    const format = document.getElementById('import_type').value;
    const exampleDiv = document.getElementById('format_example');
    
    if (format === 'coordinates') {
        exampleDiv.innerHTML = `
            <h4 class="font-semibold mb-2">Format Example (Coordinates):</h4>
            <pre class="text-sm text-gray-700 font-mono">Thiruvananthapuram, 8.5241, 76.9366, MG Road, Thiruvananthapuram, Kerala
Kochi, 9.9312, 76.2673, Marine Drive, Kochi, Kerala
Kozhikode, 11.2588, 75.7804, Beach Road, Kozhikode, Kerala</pre>
            <p class="text-xs text-gray-600 mt-2">Format: Name, Latitude, Longitude, Address, City, State</p>
        `;
    } else if (format === 'json') {
        exampleDiv.innerHTML = `
            <h4 class="font-semibold mb-2">Format Example (JSON):</h4>
            <pre class="text-sm text-gray-700 font-mono">[
  {
    "name": "Thiruvananthapuram",
    "latitude": 8.5241,
    "longitude": 76.9366,
    "address": "MG Road",
    "city": "Thiruvananthapuram",
    "state": "Kerala",
    "order": 1,
    "is_active": true
  }
]</pre>
        `;
    } else if (format === 'csv') {
        exampleDiv.innerHTML = `
            <h4 class="font-semibold mb-2">Format Example (CSV):</h4>
            <pre class="text-sm text-gray-700 font-mono">Name,Latitude,Longitude,Address,City,State,Order,IsActive
Thiruvananthapuram,8.5241,76.9366,MG Road,Thiruvananthapuram,Kerala,1,1
Kochi,9.9312,76.2673,Marine Drive,Kochi,Kerala,2,1</pre>
        `;
    }
}
</script>
@endpush
@endsection

