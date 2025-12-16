<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\User;



use App\Models\Vehicle;
use App\Models\VehicleBooking;
use Illuminate\Support\Facades\Auth;
use App\Services\DriverService;

class DashboardController extends Controller
{
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }
    public function index()
    {
        $user = Auth::user();

        // Statistik umum
        $totalVehicles = Vehicle::count();
        $totalBookings = VehicleBooking::count();

        // Booking berdasarkan status
        $pendingBookings = VehicleBooking::where('status', 'pending')->count();
        $approvedBookings = VehicleBooking::where('status', 'approved')->count();

        // Booking yang perlu approval user ini
        $needApproval = VehicleBooking::where(function ($q) use ($user) {
            $q->where('approver_level_1_id', $user->id)
              ->orWhere('approver_level_2_id', $user->id);
        })
        ->where('status', 'pending')
        ->count();

        return Inertia::render('dashboard/index', [
            'stats' => [
                'totalVehicles' => $totalVehicles,
                'totalBookings' => $totalBookings,
                'pendingBookings' => $pendingBookings,
                'approvedBookings' => $approvedBookings,
                'needApproval' => $needApproval,
            ],
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ],
            ],
        ]);
    }


    public function bookings()
    {
        $user = Auth::user();

        $bookings = VehicleBooking::with([
                'vehicle',
                'driver',
                'requester',
                'approverLevel1',
                'approverLevel2',
            ])
            ->latest()
            ->paginate(10);

        return Inertia::render('dashboard/booking', [
            'bookings' => $bookings,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ],
            ],
        ]);
    }

public function createbooking()
{
    $vehicles = Vehicle::all();
    $drivers = User::where('role', 'driver')->get();
    $approvers = User::whereIn('role', ['approver', 'manager'])->get();
   $auth = Auth::user();

    return Inertia::render('dashboard/booking/create', [
        'vehicles' => $vehicles,
        'drivers' => $drivers,
        'approvers' => $approvers,
        'auth' => [
            'user' => [
                'id' => $auth->id,
                'name' => $auth->name,
                'role' => $auth->role,
            ],
        ],
    ]);
}


public function driver()
    {
        $user = Auth::user();

    $drivers = $this->driverService->getAllDrivers(10);
 

        return Inertia::render('dashboard/driver', [
            'drivers' => $drivers,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                ],
            ],
        ]);
    }

}
