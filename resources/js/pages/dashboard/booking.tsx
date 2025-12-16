import AppLayout from '@/layouts/AppLayout';
import { Link } from '@inertiajs/react';

type Booking = {
    id: number;
    kode: string;
    vehicle: string;
    driver: string;
    date: string;
    status: 'pending' | 'approved' | 'rejected';
};

export default function VehicleBookingIndex() {
    // 🔹 DATA STATIS
    const bookings: Booking[] = [
        {
            id: 1,
            kode: '1231244',
            vehicle: 'Toyota Hilux',
            driver: 'Budi',
            date: '2025-01-10',
            status: 'pending',
        },
        {
            id: 2,
            kode: '1231244',
            vehicle: 'Mitsubishi Triton',
            driver: 'Andi',
            date: '2025-01-11',
            status: 'approved',
        },
        {
            id: 3,
            kode: '1231244',
            vehicle: 'Isuzu Elf',
            driver: 'Slamet',
            date: '2025-01-12',
            status: 'rejected',
        },
    ];

    return (
        <AppLayout>
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-800">
                    Vehicle Booking
                </h1>

                <Link
                    href="/booking/create"
                    className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    + Booking Kendaraan
                </Link>
            </div>

            <div className="mt-6 overflow-hidden rounded-xl bg-white shadow">
                <table className="w-full border-collapse text-sm">
                    <thead className="bg-gray-50 text-gray-600">
                        <tr>
                            <th className="px-4 py-3 text-left">Kode</th>
                            <th className="px-4 py-3 text-left">Kendaraan</th>
                            <th className="px-4 py-3 text-left">Driver</th>
                            <th className="px-4 py-3 text-center">Tanggal</th>
                            <th className="px-4 py-3 text-center">Status</th>
                            <th className="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {bookings.map((booking) => (
                            <tr
                                key={booking.id}
                                className="border-t text-black hover:bg-gray-50"
                            >
                                <td className="px-4 py-3">{booking.kode}</td>
                                <td className="px-4 py-3">{booking.vehicle}</td>
                                <td className="px-4 py-3">{booking.driver}</td>
                                <td className="px-4 py-3 text-center">
                                    {booking.date}
                                </td>
                                <td className="px-4 py-3 text-center">
                                    <StatusBadge status={booking.status} />
                                </td>
                                <td className="px-4 py-3 text-right">
                                    <Link
                                        href="#"
                                        className="text-blue-600 hover:underline"
                                    >
                                        Detail
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AppLayout>
    );
}

function StatusBadge({ status }: { status: string }) {
    const map: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-700',
        approved: 'bg-green-100 text-green-700',
        rejected: 'bg-red-100 text-red-700',
    };

    return (
        <span
            className={`rounded-full px-3 py-1 text-xs font-semibold ${map[status]}`}
        >
            {status.toUpperCase()}
        </span>
    );
}
