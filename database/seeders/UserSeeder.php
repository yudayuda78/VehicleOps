<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Region;
use App\Models\Office;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $regions = Region::with('offices')->get(); // eager load offices

        foreach ($regions as $region) {
            // Ambil kantor pusat dan cabang
            $headOffice = $region->offices->where('type', 'head_office')->first();
            $branchOffice = $region->offices->where('type', 'branch_office')->first();

            if (!$headOffice || !$branchOffice) {
                continue; // lewati jika office belum ada
            }

            // Admin kantor pusat
            User::updateOrCreate(
                ['email' => 'admin-ho-' . strtolower($region->code) . '@example.com'],
                [
                    'name' => 'Admin HO ' . $region->name,
                    'password' => Hash::make('password123'),
                    'role' => 'admin',
                    'region_id' => $region->id,
                    'office_id' => $headOffice->id,
                    'email_verified_at' => now(),
                ]
            );

            // Admin kantor cabang
            User::updateOrCreate(
                ['email' => 'admin-br-' . strtolower($region->code) . '@example.com'],
                [
                    'name' => 'Admin BR ' . $region->name,
                    'password' => Hash::make('password123'),
                    'role' => 'admin',
                    'region_id' => $region->id,
                    'office_id' => $branchOffice->id,
                    'email_verified_at' => now(),
                ]
            );

            // Approver kantor pusat
            foreach (range(1, 2) as $i) {
                User::updateOrCreate(
                    ['email' => "approver{$i}-ho-" . strtolower($region->code) . "@example.com"],
                    [
                        'name' => "Approver {$i} HO " . $region->name,
                        'password' => Hash::make('password123'),
                        'role' => 'approver',
                        'region_id' => $region->id,
                        'office_id' => $headOffice->id,
                        'email_verified_at' => now(),
                    ]
                );
            }

            // Approver kantor cabang
            foreach (range(1, 2) as $i) {
                User::updateOrCreate(
                    ['email' => "approver{$i}-br-" . strtolower($region->code) . "@example.com"],
                    [
                        'name' => "Approver {$i} BR " . $region->name,
                        'password' => Hash::make('password123'),
                        'role' => 'approver',
                        'region_id' => $region->id,
                        'office_id' => $branchOffice->id,
                        'email_verified_at' => now(),
                    ]
                );
            }

            // Pegawai kantor pusat
foreach (range(1, 3) as $i) {
    User::updateOrCreate(
        ['email' => "pegawai{$i}-ho-" . strtolower($region->code) . "@example.com"],
        [
            'name' => "Pegawai {$i} HO " . $region->name,
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'region_id' => $region->id,
            'office_id' => $headOffice->id,
            'email_verified_at' => now(),
        ]
    );
}

// Pegawai kantor cabang
foreach (range(1, 3) as $i) {
    User::updateOrCreate(
        ['email' => "pegawai{$i}-br-" . strtolower($region->code) . "@example.com"],
        [
            'name' => "Pegawai {$i} BR " . $region->name,
            'password' => Hash::make('password123'),
            'role' => 'pegawai',
            'region_id' => $region->id,
            'office_id' => $branchOffice->id,
            'email_verified_at' => now(),
        ]
    );
}

        }
    }
}
