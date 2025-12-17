<?php

namespace App\Console\Commands;

use App\Models\Destination;
use Illuminate\Console\Command;

class ImportGoogleMapsDestinations extends Command
{
    protected $signature = 'destinations:import-google-maps {file?}';
    protected $description = 'Import destinations from Google Maps data';

    public function handle()
    {
        $this->info('Google Maps Destination Import');
        $this->info('=============================');
        $this->newLine();
        
        $this->info('To import destinations from your Google Maps:');
        $this->info('1. Open: https://www.google.com/maps/d/u/0/edit?mid=1vdYRgLz992EMqWi2e0q6tfMfMVZgqOc&usp=sharing');
        $this->info('2. For each location, get the coordinates (right-click > coordinates)');
        $this->info('3. Use the admin panel import feature at: /admin/destinations/import');
        $this->newLine();
        
        $this->info('Or manually add destinations using the format:');
        $this->info('Name, Latitude, Longitude, Address, City, State');
        $this->newLine();
        
        // Example destinations for Kerala (common locations)
        $exampleDestinations = [
            ['Thiruvananthapuram', 8.5241, 76.9366, 'MG Road', 'Thiruvananthapuram', 'Kerala'],
            ['Kochi', 9.9312, 76.2673, 'Marine Drive', 'Kochi', 'Kerala'],
            ['Kozhikode', 11.2588, 75.7804, 'Beach Road', 'Kozhikode', 'Kerala'],
            ['Thrissur', 10.5276, 76.2144, 'Round South', 'Thrissur', 'Kerala'],
            ['Kannur', 11.8745, 75.3704, 'Payyambalam Beach', 'Kannur', 'Kerala'],
        ];

        if ($this->confirm('Would you like to add example destinations?', false)) {
            foreach ($exampleDestinations as $index => $dest) {
                Destination::firstOrCreate(
                    ['name' => $dest[0], 'latitude' => $dest[1], 'longitude' => $dest[2]],
                    [
                        'address' => $dest[3],
                        'city' => $dest[4],
                        'state' => $dest[5],
                        'order' => $index + 1,
                        'is_active' => true,
                    ]
                );
            }
            $this->info('Example destinations added successfully!');
        }

        return 0;
    }
}

