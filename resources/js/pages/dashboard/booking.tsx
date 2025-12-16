import AppLayout from '@/layouts/AppLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { useState } from 'react';

type Booking = {
    id: number;
    vehicle: { name: string };
    driver: { name: string };
    date: string;
    status: 'pending' | 'approved' | 'rejected';
};

type PaginatedBooking = {
    current_page: number;
    data: Booking[];
};

type AuthUser = {
    id: number;
    name: string;
    role: string;
};

type PageProps = {
    bookings: PaginatedBooking;
    auth: {
        user: AuthUser;
    };
};

export default function VehicleBookingIndex() {
    const { bookings, auth } = usePage<PageProps>().props;
    const [showModal, setShowModal] = useState(false);
    const [rejectBookingId, setRejectBookingId] = useState<number | null>(null);

    console.log('User ID:', auth.user.office.type);

    function handleApproval(id: number, status: 'approved' | 'rejected') {
        if (status === 'rejected') {
            // Tampilkan modal konfirmasi
            setRejectBookingId(id);
            setShowModal(true);

            return;
        }

        // Contoh panggil API Inertia untuk update status
        router.post('approvelevel1', {
            id,
            status,
        });
    }

    function confirmReject() {
        if (rejectBookingId !== null) {
            router.post('approvelevel1', {
                id: rejectBookingId,
                status: 'rejected',
            });
            setShowModal(false);
            setRejectBookingId(null);
        }
    }

    function cancelReject() {
        setShowModal(false);
        setRejectBookingId(null);
    }

    function handleApproval2(id: number, status: 'approved' | 'rejected') {
        if (status === 'rejected') {
            // Tampilkan modal konfirmasi
            setRejectBookingId(id);
            setShowModal(true);

            return;
        }

        // Contoh panggil API Inertia untuk update status
        router.post('approvelevel2', {
            id,
            status,
        });
    }

    function confirmReject2() {
        if (rejectBookingId !== null) {
            router.post('approvelevel2', {
                id: rejectBookingId,
                status: 'rejected',
            });
            setShowModal(false);
            setRejectBookingId(null);
        }
    }

    function cancelReject2() {
        setShowModal(false);
        setRejectBookingId(null);
    }

    return (
        <AppLayout>
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-800">
                    Vehicle Booking
                </h1>

                <button
                    onClick={() => {
                        const startDate = '2025-01-01';
                        const endDate = '2025-01-31';
                        window.location.href = `/booking/export?start_date=${startDate}&end_date=${endDate}`;
                    }}
                    className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Export Excel
                </button>

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
                            <th className="px-4 py-3 text-left">Kendaraan</th>
                            <th className="px-4 py-3 text-left">Driver</th>
                            <th className="px-4 py-3 text-center">Tanggal</th>
                            <th className="px-4 py-3 text-center">Status</th>
                            {auth.user.role !== 'admin' && (
                                <th className="px-4 py-3 text-center">Aksi</th>
                            )}
                        </tr>
                    </thead>
                    <tbody>
                        {bookings.data.map((booking) => (
                            <tr
                                key={booking.id}
                                className="border-t text-black hover:bg-gray-50"
                            >
                                <td className="px-4 py-3">
                                    {booking.vehicle.name}
                                </td>
                                <td className="px-4 py-3">
                                    {booking.driver.name}
                                </td>
                                <td className="px-4 py-3 text-center">
                                    {booking.date}
                                </td>
                                <td className="px-4 py-3 text-center">
                                    <StatusBadge status={booking.status} />
                                </td>

                                {auth.user.office?.type === 'branch_office' &&
                                    auth.user.role === 'approver' && (
                                        <td className="px-4 py-3 text-right">
                                            <div className="flex justify-end gap-2">
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        handleApproval(
                                                            booking.id,
                                                            'approved',
                                                        )
                                                    }
                                                    className="flex items-center gap-1 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-green-700"
                                                >
                                                    Approve
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        handleApproval(
                                                            booking.id,
                                                            'rejected',
                                                        )
                                                    }
                                                    className="flex items-center gap-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-red-700"
                                                >
                                                    Reject
                                                </button>
                                            </div>
                                        </td>
                                    )}

                                {auth.user.office?.type === 'head_office' &&
                                    auth.user.role === 'approver' && (
                                        <td className="px-4 py-3 text-right">
                                            <div className="flex justify-end gap-2">
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        handleApproval2(
                                                            booking.id,
                                                            'approved',
                                                        )
                                                    }
                                                    className="flex items-center gap-1 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-green-700"
                                                >
                                                    Approve
                                                </button>
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        handleApproval2(
                                                            booking.id,
                                                            'rejected',
                                                        )
                                                    }
                                                    className="flex items-center gap-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow transition hover:bg-red-700"
                                                >
                                                    Reject
                                                </button>
                                            </div>
                                        </td>
                                    )}
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* Modal Konfirmasi Reject */}
            {showModal && (
                <div
                    className="fixed inset-0 z-50 flex items-center justify-center bg-black/10 backdrop-blur-sm"
                    onClick={cancelReject}
                >
                    <div className="w-96 rounded-lg bg-white p-6 shadow-lg">
                        <h2 className="mb-4 text-lg font-semibold text-gray-800">
                            Konfirmasi Reject
                        </h2>
                        <p className="mb-6">
                            Apakah Anda yakin ingin menolak booking ini?
                        </p>
                        <div className="flex justify-end gap-3">
                            <button
                                onClick={cancelReject}
                                className="rounded-lg bg-gray-300 px-4 py-2 text-gray-700 transition hover:bg-gray-400"
                            >
                                Batal
                            </button>
                            <button
                                onClick={confirmReject}
                                className="rounded-lg bg-red-600 px-4 py-2 text-white transition hover:bg-red-700"
                            >
                                Reject
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AppLayout>
    );
}

function StatusBadge({ status }: { status: string }) {
    const map: Record<string, string> = {
        pending: 'bg-yellow-100 text-yellow-700',
        approved: 'bg-green-100 text-green-700',
        rejected: 'bg-red-100 text-red-700',
        draft: 'bg-gray-100 text-black',
    };

    return (
        <span
            className={`rounded-full px-3 py-1 text-xs font-semibold ${map[status]}`}
        >
            {status.toUpperCase()}
        </span>
    );
}
