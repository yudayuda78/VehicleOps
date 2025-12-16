<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = [
            [
                'id' => 1,
                'name' => 'Toyota Hilux',
                'type' => 'Angkutan Barang',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'name' => 'Isuzu Elf',
                'type' => 'Angkutan Orang',
                'status' => 'Maintenance',
            ],
        ];

        return Inertia::render('vehicle/index', [
            'vehicles' => $vehicles,
        ]);
    }
}
