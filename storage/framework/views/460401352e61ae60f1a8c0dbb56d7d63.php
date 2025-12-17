

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Caravan Map - Live Tracking</h2>
                
                <!-- Map Controls -->
                <div class="mb-4 flex flex-wrap gap-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="showDestinations" checked onchange="toggleDestinations()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Show Destinations</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="showCaravans" checked onchange="toggleCaravans()" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Show Caravans</span>
                    </label>
                </div>
                
                <!-- Map Container -->
                <div id="map" style="height: 600px; width: 100%;"></div>

                <!-- Destinations List -->
                <?php if($destinations->count() > 0): ?>
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-3">Destinations (<?php echo e($destinations->count()); ?>)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border rounded-lg p-3 hover:shadow-md transition-shadow bg-red-50">
                                <h4 class="font-bold text-sm">📍 <?php echo e($destination->name); ?></h4>
                                <p class="text-xs text-gray-600"><?php echo e($destination->city ?? ''); ?>, <?php echo e($destination->state ?? ''); ?></p>
                                <?php if($destination->order): ?>
                                    <p class="text-xs text-gray-500">Order: <?php echo e($destination->order); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Caravan List -->
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-3">Active Caravans</h3>
                    <div id="caravan-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $caravans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caravan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer" 
                                 onclick="focusCaravan(<?php echo e($caravan->id); ?>)"
                                 data-caravan-id="<?php echo e($caravan->id); ?>">
                                <h4 class="font-bold text-lg"><?php echo e($caravan->name); ?></h4>
                                <p class="text-sm text-gray-600"><?php echo e($caravan->vehicle_number); ?></p>
                                <?php if($caravan->latestLocation): ?>
                                    <p class="text-xs text-gray-500 mt-2">
                                        Last updated: <?php echo e($caravan->latestLocation->tracked_at->diffForHumans()); ?>

                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Location: <?php echo e($caravan->latestLocation->city ?? 'N/A'); ?>, <?php echo e($caravan->latestLocation->state ?? 'N/A'); ?>

                                    </p>
                                <?php else: ?>
                                    <p class="text-xs text-red-500 mt-2">No location data available</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let map;
    let markers = {};
    let destinationMarkers = [];
    let updateInterval;

    // Initialize map centered on Kerala
    function initMap() {
        map = L.map('map').setView([10.5276, 76.2144], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Add destination markers
        <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            addDestinationMarker(<?php echo e($destination->id); ?>, <?php echo e($destination->latitude); ?>, <?php echo e($destination->longitude); ?>, '<?php echo e(addslashes($destination->name)); ?>', '<?php echo e(addslashes($destination->city ?? '')); ?>', '<?php echo e(addslashes($destination->state ?? '')); ?>', <?php echo e($destination->order); ?>);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        // Add markers for each caravan
        <?php $__currentLoopData = $caravans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caravan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($caravan->latestLocation): ?>
                addCaravanMarker(<?php echo e($caravan->id); ?>, <?php echo e($caravan->latestLocation->latitude); ?>, <?php echo e($caravan->latestLocation->longitude); ?>, '<?php echo e(addslashes($caravan->name)); ?>', '<?php echo e($caravan->vehicle_number); ?>');
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    function addCaravanMarker(caravanId, lat, lng, name, vehicleNumber) {
        // Custom icon for caravans - blue van
        const icon = L.divIcon({
            className: 'caravan-marker',
            html: `<div style="background-color: #4F46E5; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">🚐</div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        const marker = L.marker([lat, lng], { icon: icon }).addTo(map);
        
        marker.bindPopup(`
            <div>
                <h3 class="font-bold text-indigo-600">🚐 ${name}</h3>
                <p class="text-sm">${vehicleNumber}</p>
                <a href="/map/${caravanId}" class="text-blue-500 hover:underline text-sm">View Details</a>
            </div>
        `);

        markers[caravanId] = marker;
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

    function toggleCaravans() {
        const show = document.getElementById('showCaravans').checked;
        Object.values(markers).forEach(marker => {
            if (show) {
                marker.addTo(map);
            } else {
                map.removeLayer(marker);
            }
        });
    }

    function focusCaravan(caravanId) {
        if (markers[caravanId]) {
            map.setView(markers[caravanId].getLatLng(), 12);
            markers[caravanId].openPopup();
        }
    }

    // Update locations periodically
    function updateLocations() {
        fetch('/api/locations')
            .then(response => response.json())
            .then(data => {
                data.forEach(caravan => {
                    if (caravan.latitude && caravan.longitude) {
                        if (markers[caravan.id]) {
                            // Update existing marker
                            markers[caravan.id].setLatLng([caravan.latitude, caravan.longitude]);
                        } else {
                            // Add new marker
                            addCaravanMarker(caravan.id, caravan.latitude, caravan.longitude, caravan.name, caravan.vehicle_number);
                        }
                    }
                });
            })
            .catch(error => console.error('Error updating locations:', error));
    }

    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Update locations every 30 seconds
        updateInterval = setInterval(updateLocations, 30000);
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (updateInterval) {
            clearInterval(updateInterval);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\samastha\resources\views/map/index.blade.php ENDPATH**/ ?>