<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $regions = [
            [
                'name' => 'Jakarta',
                'code' => 'HO',
                'description' => 'Head Office / Kantor Pusat',
            ],
            [
                'name' => 'Kalimantan Timur',
                'code' => 'KALTIM',
                'description' => 'Region tambang Kalimantan Timur',
            ],
            [
                'name' => 'Kalimantan Selatan',
                'code' => 'KALSEL',
                'description' => 'Region tambang Kalimantan Selatan',
            ],
            [
                'name' => 'Sulawesi Tenggara',
                'code' => 'SULTRA',
                'description' => 'Region tambang Sulawesi Tenggara',
            ],
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(
                ['code' => $region['code']],
                $region
            );
        }
    }
}
