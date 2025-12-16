<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;
use App\Models\Region;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $regions = Region::all();

        foreach ($regions as $region) {

            // Kantor Pusat
            Office::updateOrCreate(
                [
                    'code' => 'HO-' . $region->code,
                ],
                [
                    'region_id' => $region->id,
                    'name' => 'Kantor Pusat ' . $region->name,
                    'type' => 'head_office',
                    'address' => 'Kantor pusat region ' . $region->name,
                ]
            );

            // Kantor Cabang
            Office::updateOrCreate(
                [
                    'code' => 'BR-' . $region->code,
                ],
                [
                    'region_id' => $region->id,
                    'name' => 'Kantor Cabang ' . $region->name,
                    'type' => 'branch_office',
                    'address' => 'Kantor cabang region ' . $region->name,
                ]
            );
        }
    }
}
