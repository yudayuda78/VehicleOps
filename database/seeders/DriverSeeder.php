<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\Region;
use App\Models\Office;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = Region::all();

        foreach ($regions as $region) {
            // Ambil semua kantor di region ini
            $offices = Office::where('region_id', $region->id)->get();

            foreach ($offices as $office) {
                // Tambah 3 driver per kantor
                for ($i = 1; $i <= 3; $i++) {
                    Driver::updateOrCreate(
                        [
                            'name' => "Driver {$i} - {$office->name}"
                        ],
                        [
                            'region_id' => $region->id,
                            'office_id' => $office->id,
                            'status' => 'active',
                        ]
                    );
                }
            }
        }
    }
}
