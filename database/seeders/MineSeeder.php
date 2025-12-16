<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mine;
use App\Models\Office;
use Illuminate\Support\Str;

class MineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kantor cabang
        $branchOffices = Office::where('type', 'branch_office')->get();

        foreach ($branchOffices as $office) {
            for ($i = 1; $i <= 6; $i++) {
                $code = 'TM' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-' . $office->code;
                Mine::updateOrCreate(
                    ['code' => $code],
                    [
                        'name' => 'Tambang ' . $i . ' ' . $office->name,
                        'region_id' => $office->region_id,
                        'address' => 'Alamat Tambang ' . $i . ' ' . $office->name,
                        'city' => 'Kota ' . $i,
                        'province' => 'Provinsi ' . $i,
                        'is_active' => true,
                        'description' => 'Tambang milik ' . $office->name,
                    ]
                );
            }
        }
    }
}
