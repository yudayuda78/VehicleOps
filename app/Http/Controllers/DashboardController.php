<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Inertia\Inertia;
use App\Models\User;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleBookingsExport;
use App\Models\BookingLog;

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
        

          $query = VehicleBooking::with([
        'vehicle',
        'driver',
        'requester',
        'approverLevel1',
        'approverLevel2',
    ])->latest();

    // Filter berdasarkan role dan office
    if ($user->role === 'approver') {
      
        if ($user->office->type === 'branch_office') {
             
            $query->where('status', 'draft');
        } elseif ($user->office->type === 'head_office') {
            $query->where('status', 'pending');
        }
    }

    $bookings = $query->paginate(10);


     

        return Inertia::render('dashboard/booking', [
            'bookings' => $bookings,
            'auth' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'office' => $user->office,
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

     BookingLog::create([
        'booking_id' => $booking->id,
        'user_id' => $auth->id,
        'action' => 'created',
        'note' => 'Booking dibuat oleh ' . $auth->name,
    ]);

    // Return response (Inertia redirect)
    return redirect()->route('dashboard.bookings')
                     ->with('success', 'Booking berhasil dibuat!');
}

public function approveLevel1(Request $request){
    $auth = Auth::user();

    $id = $request->id;
 
    if($request->status === "approved"){
        
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Pending";
        $booking->save();

        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => $auth->id,
            'action' => 'approved',
            'note' => 'Booking disetujui oleh ' . $auth->name . ' (Level 1)',
        ]);
   
    }else if($request->status === "rejected"){
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Rejected";
        $booking->save();  

        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => $auth->id,
            'action' => 'rejected',
            'note' => 'Booking tidak disetujui oleh ' . $auth->name . ' (Level 1)',
        ]);
    }
    
    
    return redirect()->route('dashboard.bookings');
}



public function approveLevel2(Request $request){
    $auth = Auth::user();
    if($request->status === "approved"){
        
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Approved";
        $booking->save();

        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => $auth->id,
            'action' => 'approved',
            'note' => 'Booking disetujui oleh ' . $auth->name . ' (Level 2)',
        ]);
   
    }else if($request->status === "rejected"){
        $id = $request->id; // ambil dari body request
        $booking = VehicleBooking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        $booking->status = "Rejected";
        $booking->save();  

        BookingLog::create([
            'booking_id' => $booking->id,
            'user_id' => $auth->id,
            'action' => 'rejected',
            'note' => 'Booking tidak disetujui oleh ' . $auth->name . ' (Level 2)',
        ]);
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

public function vehicle(){
    $fuelUsage = VehicleBooking::select(
        'vehicle_id',
        DB::raw('COUNT(*) as total_usage')
    )
    ->groupBy('vehicle_id')
    ->with('vehicle')
    ->get();

    // 2️⃣ Jadwal Service: ambil kendaraan dengan tanggal service berikutnya
    $vehiclesService = Vehicle::select('id','name','next_service_date','service_interval_km','status')
        ->whereNotNull('next_service_date')
        ->orderBy('next_service_date')
        ->get();

    // 3️⃣ Riwayat pemakaian kendaraan: booking terakhir
    $usageHistory = VehicleBooking::with(['vehicle','driver','user'])
        ->latest()
        ->limit(20) // misal tampilkan 20 terakhir
        ->get();

    return Inertia::render('dashboard/vehicle', [
        'fuelUsage' => $fuelUsage,
        'vehiclesService' => $vehiclesService,
        'usageHistory' => $usageHistory,
    ]);
}


public function exportBooking(Request $request)
{
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    return Excel::download(new VehicleBookingsExport($startDate, $endDate), 'vehicle_bookings.xlsx');
}

public function laporan(Request $request){
        $query = VehicleBooking::with(['vehicle', 'driver', 'user']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        $bookings = $query->orderBy('date','desc')->get();

        return Inertia::render('dashboard/laporan', [
            'bookings' => $bookings,
            'filters' => $request->only(['start_date','end_date'])
        ]);
}

public function logs(){
       $logs = BookingLog::with(['booking', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'booking_id' => $log->booking_id,
                    'vehicle' => $log->booking->vehicle->name ?? '-',
                    'user' => $log->user->name,
                    'action' => $log->action,
                    'note' => $log->note,
                    'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return Inertia::render('dashboard/logs', [
            'logs' => $logs,
        ]);
}


}
