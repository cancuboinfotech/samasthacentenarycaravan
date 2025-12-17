

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Active Caravans</h3>
                    <p class="text-3xl font-bold text-blue-600"><?php echo e($caravansCount); ?></p>
                </div>
                
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-green-900 mb-2">Active Destinations</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo e($destinationsCount); ?></p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <a href="<?php echo e(route('admin.destinations.import')); ?>" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Import from Google Maps
                    </a>
                    <a href="<?php echo e(route('admin.destinations.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Add New Destination
                    </a>
                    <a href="<?php echo e(route('admin.destinations.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Manage Destinations
                    </a>
                    <a href="<?php echo e(route('map.index')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        View Map
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold mb-4">Recent Caravans</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $recentCaravans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caravan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo e($caravan->name); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($caravan->vehicle_number); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if($caravan->latestLocation): ?>
                                            <?php echo e($caravan->latestLocation->city ?? 'N/A'); ?>, <?php echo e($caravan->latestLocation->state ?? 'N/A'); ?>

                                        <?php else: ?>
                                            No location data
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?php echo e(route('map.show', $caravan)); ?>" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No caravans found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\samastha\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>