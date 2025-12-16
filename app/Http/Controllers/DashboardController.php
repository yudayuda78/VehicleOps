<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Inertia\Inertia;
use App\Models\User;




use App\Models\Vehicle;
use App\Models\VehicleBooking;
use Illuminate\Support\Facades\Auth;
use App\Services\DriverService;
use Illuminate\Http\Request;

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
   $auth = Auth::user();

    // Kendaraan di region yang sama dengan user
    $vehicles = Vehicle::where('region_id', $auth->region_id)->get();

    // Driver di region yang sama dengan user
    $drivers = Driver::where('region_id', $auth->region_id)->get();

    // Approver di region yang sama dengan user
    // Approver Level 1: branch office
$approverLevel1 = User::where('role', 'approver')
    ->whereHas('office', function ($q) use ($auth) {
        $q->where('type', 'branch_office')
          ->where('region_id', $auth->region_id);
    })
    ->get();

// Approver Level 2: head office di region user
$approverLevel2 = User::where('role', 'approver')
    ->whereHas('office', function ($q) use ($auth) {
        $q->where('type', 'head_office')
          ->where('region_id', $auth->region_id);
    })
    ->get();
 

    return Inertia::render('dashboard/booking/create', [
        'vehicles' => $vehicles,
        'drivers' => $drivers,
        'approverLevel1' => $approverLevel1,
        'approverLevel2' => $approverLevel2,
        'auth' => [
            'user' => [
                'id' => $auth->id,
                'name' => $auth->name,
                'role' => $auth->role,
            ],
        ],
    ]);
}


public function storeBooking(Request $request)
{
    $auth = Auth::user();
 

    // Validasi input
    $validated = $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'driver_id' => 'required|exists:drivers,id',
        'approver_level_1_id' => 'required|exists:users,id',
        'approver_level_2_id' => 'required|exists:users,id',
        'date' => 'required|date',
    ]);

    // Simpan booking
    $booking = VehicleBooking::create([
        'region_id' => $auth->region_id, 
        'vehicle_id' => $validated['vehicle_id'],
        'driver_id' => $validated['driver_id'],
        'approver_level_1_id' => $validated['approver_level_1_id'],
        'approver_level_2_id' => $validated['approver_level_2_id'],
        'date' => $validated['date'],
        'user_id' => $auth->id,         // siapa yang request
        'created_by' => $auth->id,
        'status' => 'draft',          // default status
    ]);

    // Return response (Inertia redirect)
    return redirect()->route('dashboard.bookings')
                     ->with('success', 'Booking berhasil dibuat!');
}

public function approveLevel1(Request $request){
 
    if($request->status === "approved"){
        
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Pending";
        $booking->save();
   
    }else if($request->status === "rejected"){
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Rejected";
        $booking->save();  
    }
    
    
    return redirect()->route('dashboard.bookings');
}



public function approveLevel2(Request $request){
 
    if($request->status === "approved"){
        
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Approved";
        $booking->save();
   
    }else if($request->status === "rejected"){
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Rejected";
        $booking->save();  
    }
    
    
    return redirect()->route('dashboard.bookings');
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
