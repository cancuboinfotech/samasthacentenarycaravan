

<?php $__env->startSection('content'); ?>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">All Caravans</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__empty_1 = true; $__currentLoopData = $caravans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caravan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-xl font-bold mb-2"><?php echo e($caravan->name); ?></h3>
                            <p class="text-gray-600 mb-2">Vehicle: <?php echo e($caravan->vehicle_number); ?></p>
                            
                            <?php if($caravan->description): ?>
                                <p class="text-sm text-gray-500 mb-3"><?php echo e($caravan->description); ?></p>
                            <?php endif; ?>

                            <?php if($caravan->driver_name): ?>
                                <p class="text-sm mb-1"><strong>Driver:</strong> <?php echo e($caravan->driver_name); ?></p>
                            <?php endif; ?>

                            <?php if($caravan->latestLocation): ?>
                                <div class="mt-4 p-3 bg-blue-50 rounded">
                                    <p class="text-sm"><strong>Current Location:</strong></p>
                                    <p class="text-sm"><?php echo e($caravan->latestLocation->city ?? 'N/A'); ?>, <?php echo e($caravan->latestLocation->state ?? 'N/A'); ?></p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Updated: <?php echo e($caravan->latestLocation->tracked_at->diffForHumans()); ?>

                                    </p>
                                </div>
                                <a href="<?php echo e(route('map.show', $caravan)); ?>" class="mt-3 inline-block text-blue-500 hover:underline text-sm">
                                    View on Map →
                                </a>
                            <?php else: ?>
                                <div class="mt-4 p-3 bg-gray-50 rounded">
                                    <p class="text-sm text-gray-500">No location data available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-3 text-center text-gray-500 py-8">
                            No caravans found
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\samastha\resources\views/caravans/index.blade.php ENDPATH**/ ?>