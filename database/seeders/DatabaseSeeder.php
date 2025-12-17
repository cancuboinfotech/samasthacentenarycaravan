<?php

namespace Database\Seeders;

use App\Models\Caravan;
use App\Models\CaravanLocation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample caravans
        $caravan1 = Caravan::create([
            'name' => 'Samastha Centenary Caravan 1',
            'vehicle_number' => 'KL-01-AB-1234',
            'description' => 'Main centenary message caravan',
            'driver_name' => 'John Doe',
            'driver_phone' => '+91-9876543210',
            'is_active' => true,
        ]);

        $caravan2 = Caravan::create([
            'name' => 'Samastha Centenary Caravan 2',
            'vehicle_number' => 'KL-02-CD-5678',
            'description' => 'Secondary caravan',
            'driver_name' => 'Jane Smith',
            'driver_phone' => '+91-9876543211',
            'is_active' => true,
        ]);

        // Add sample locations for caravan 1
        CaravanLocation::create([
            'caravan_id' => $caravan1->id,
            'latitude' => 8.5241,
            'longitude' => 76.9366,
            'address' => 'Thiruvananthapuram',
            'city' => 'Thiruvananthapuram',
            'state' => 'Kerala',
            'speed' => 45.5,
            'heading' => 90.0,
            'tracked_at' => now(),
        ]);

        // Add sample locations for caravan 2
        CaravanLocation::create([
            'caravan_id' => $caravan2->id,
            'latitude' => 9.9312,
            'longitude' => 76.2673,
            'address' => 'Kochi',
            'city' => 'Kochi',
            'state' => 'Kerala',
            'speed' => 50.0,
            'heading' => 180.0,
            'tracked_at' => now(),
        ]);
    }
}

