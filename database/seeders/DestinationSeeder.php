<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Thiruvananthapuram',
                'description' => 'Capital city of Kerala',
                'latitude' => 8.5241,
                'longitude' => 76.9366,
                'address' => 'MG Road',
                'city' => 'Thiruvananthapuram',
                'state' => 'Kerala',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Kollam',
                'description' => 'Port city in Kerala',
                'latitude' => 8.8932,
                'longitude' => 76.6141,
                'address' => 'Kollam Beach',
                'city' => 'Kollam',
                'state' => 'Kerala',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Alappuzha',
                'description' => 'Venice of the East',
                'latitude' => 9.4981,
                'longitude' => 76.3388,
                'address' => 'Alappuzha Beach',
                'city' => 'Alappuzha',
                'state' => 'Kerala',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Kottayam',
                'description' => 'Land of Letters, Lakes and Latex',
                'latitude' => 9.5916,
                'longitude' => 76.5222,
                'address' => 'Kottayam Town',
                'city' => 'Kottayam',
                'state' => 'Kerala',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Kochi',
                'description' => 'Queen of Arabian Sea',
                'latitude' => 9.9312,
                'longitude' => 76.2673,
                'address' => 'Marine Drive',
                'city' => 'Kochi',
                'state' => 'Kerala',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Thrissur',
                'description' => 'Cultural Capital of Kerala',
                'latitude' => 10.5276,
                'longitude' => 76.2144,
                'address' => 'Round South',
                'city' => 'Thrissur',
                'state' => 'Kerala',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Palakkad',
                'description' => 'Gateway to Kerala',
                'latitude' => 10.7867,
                'longitude' => 76.6548,
                'address' => 'Palakkad Fort',
                'city' => 'Palakkad',
                'state' => 'Kerala',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Malappuram',
                'description' => 'City of Hills',
                'latitude' => 11.0509,
                'longitude' => 76.0711,
                'address' => 'Malappuram Town',
                'city' => 'Malappuram',
                'state' => 'Kerala',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Kozhikode',
                'description' => 'City of Spices',
                'latitude' => 11.2588,
                'longitude' => 75.7804,
                'address' => 'Beach Road',
                'city' => 'Kozhikode',
                'state' => 'Kerala',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Kannur',
                'description' => 'Crown of Kerala',
                'latitude' => 11.8745,
                'longitude' => 75.3704,
                'address' => 'Payyambalam Beach',
                'city' => 'Kannur',
                'state' => 'Kerala',
                'order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Kasaragod',
                'description' => 'Land of Gods',
                'latitude' => 12.4996,
                'longitude' => 74.9869,
                'address' => 'Kasaragod Town',
                'city' => 'Kasaragod',
                'state' => 'Kerala',
                'order' => 11,
                'is_active' => true,
            ],
            [
                'name' => 'Idukki',
                'description' => 'Spice Garden of Kerala',
                'latitude' => 9.8497,
                'longitude' => 76.9720,
                'address' => 'Idukki Town',
                'city' => 'Idukki',
                'state' => 'Kerala',
                'order' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Wayanad',
                'description' => 'Green Paradise',
                'latitude' => 11.6854,
                'longitude' => 76.1320,
                'address' => 'Kalpetta',
                'city' => 'Wayanad',
                'state' => 'Kerala',
                'order' => 13,
                'is_active' => true,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::firstOrCreate(
                ['name' => $destination['name']],
                $destination
            );
        }
    }
}

