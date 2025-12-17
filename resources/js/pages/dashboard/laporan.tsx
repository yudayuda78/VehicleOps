import AppLayout from '@/layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import { useState } from 'react';

interface Booking {
    id: number;
    vehicle: { name: string };
    driver: { name: string };
    user: { name: string };
    date: string;
    status: string;
}

interface LaporanProps {
    bookings: Booking[];
    filters: {
        start_date?: string;
        end_date?: string;
    };
}

export default function Laporan() {
    // Cast props via unknown untuk menghindari error TypeScript
    const { bookings, filters } = usePage().props as unknown as LaporanProps;

    const [startDate, setStartDate] = useState(filters.start_date || '');
    const [endDate, setEndDate] = useState(filters.end_date || '');

    const handleFilter = () => {
        if (!startDate || !endDate) {
            alert('Pilih tanggal mulai dan akhir');
            return;
        }
        window.location.href = `/laporan?start_date=${startDate}&end_date=${endDate}`;
    };

    const handleExport = () => {
        if (!startDate || !endDate) {
            alert('Pilih tanggal mulai dan akhir');
            return;
        }
        window.location.href = `/booking/export?start_date=${startDate}&end_date=${endDate}`;
    };

    return (
        <AppLayout>
            <div className="p-6">
                <h1 className="mb-4 text-xl font-bold">
                    Laporan Pemesanan Kendaraan
                </h1>

                <div className="mb-4 flex items-center gap-2">
                    <input
                        type="date"
                        value={startDate}
                        onChange={(e) => setStartDate(e.target.value)}
                        className="rounded-lg border px-3 py-2 text-sm text-black"
                    />
                    <input
                        type="date"
                        value={endDate}
                        onChange={(e) => setEndDate(e.target.value)}
                        className="rounded-lg border px-3 py-2 text-sm text-black"
                    />
                    <button
                        onClick={handleFilter}
                        className="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Filter
                    </button>
                    <button
                        onClick={handleExport}
                        className="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    >
                        Export Excel
                    </button>
                </div>

                <div className="overflow-x-auto text-black">
                    <table className="min-w-full rounded-lg border bg-white">
                        <thead className="bg-gray-100">
                            <tr>
                                <th className="border px-4 py-2">ID</th>
                                <th className="border px-4 py-2">Vehicle</th>
                                <th className="border px-4 py-2">Driver</th>
                                <th className="border px-4 py-2">Requester</th>
                                <th className="border px-4 py-2">Date</th>
                                <th className="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {bookings.map((booking) => (
                                <tr key={booking.id}>
                                    <td className="border px-4 py-2">
                                        {booking.id}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {booking.vehicle.name}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {booking.driver.name}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {booking.user.name}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {booking.date}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {booking.status}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
