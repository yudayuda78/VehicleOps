<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use App\Models\Region;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = Region::all();

        foreach ($regions as $region) {

            // Angkutan orang: 5 kendaraan
            for ($i = 1; $i <= 5; $i++) {
                Vehicle::updateOrCreate(
                    ['plate_number' => "P-{$region->code}-O00{$i}"],
                    [
                        'name' => "Mobil Penumpang {$i} - {$region->code}",
                        'type' => 'angkutan orang',
                        'year' => 2018 + $i,
                        'ownership' => $i % 2 == 0 ? 'office' : 'outsource',
                        'fuel_type' => $i % 2 == 0 ? 'solar' : 'bensin',
                        'fuel_consumption' => rand(5, 10),
                        'last_service_date' => now()->subMonths(rand(1,6)),
                        'next_service_date' => now()->addMonths(rand(3,6)),
                        'service_interval_km' => 10000 + $i * 2000,
                        'status' => 'available',
                        'region_id' => $region->id,
                    ]
                );
            }

            // Angkutan barang: 3 kendaraan
            for ($i = 1; $i <= 3; $i++) {
                Vehicle::updateOrCreate(
                    ['plate_number' => "P-{$region->code}-B00{$i}"],
                    [
                        'name' => "Truk Barang {$i} - {$region->code}",
                        'type' => 'angkutan barang',
                        'year' => 2017 + $i,
                        'ownership' => 'office',
                        'fuel_type' => 'solar',
                        'fuel_consumption' => rand(3, 6),
                        'last_service_date' => now()->subMonths(rand(2,7)),
                        'next_service_date' => now()->addMonths(rand(2,5)),
                        'service_interval_km' => 12000 + $i * 1000,
                        'status' => 'available',
                        'region_id' => $region->id,
                    ]
                );
            }
        }
    }
}
