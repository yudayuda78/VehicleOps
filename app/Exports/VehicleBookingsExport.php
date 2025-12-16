<?php

namespace App\Exports;

use App\Models\VehicleBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleBookingsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = VehicleBooking::with(['vehicle', 'driver', 'user']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($booking) {
            return [
                'ID' => $booking->id,
                'Vehicle' => $booking->vehicle->name,
                'Driver' => $booking->driver->name,
                'Requester' => $booking->user->name,
                'Date' => $booking->date,
                'Status' => $booking->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'Vehicle', 'Driver', 'Requester', 'Date', 'Status'];
    }
}
