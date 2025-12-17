import AppLayout from '@/layouts/AppLayout';
import { usePage } from '@inertiajs/react';

export default function Dashboard() {
    const { props } = usePage<any>();
    const user = props.auth?.user;

    return (
        <AppLayout>
            <div className="mx-auto max-w-7xl p-6">
                <div className="mb-6">
                    <h1 className="text-3xl font-bold text-gray-900">
                        Selamat datang{user ? `, ${user.name}` : ''}
                    </h1>
                    <p className="mt-2 text-lg text-gray-500">
                        Role:{' '}
                        <span className="font-semibold text-gray-700">
                            {user?.role ?? '-'}
                        </span>
                    </p>
                </div>

                {/* Card Statistik / Info */}
                <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <div className="rounded-xl bg-white p-5 shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <h2 className="text-sm font-medium text-gray-400 uppercase">
                            Total Booking
                        </h2>
                        <p className="mt-2 text-2xl font-bold text-gray-900">
                            {props.stats?.totalBookings ?? 0}
                        </p>
                    </div>

                    <div className="rounded-xl bg-white p-5 shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <h2 className="text-sm font-medium text-gray-400 uppercase">
                            Booking Aktif
                        </h2>
                        <p className="mt-2 text-2xl font-bold text-gray-900">
                            {props.stats?.activeBookings ?? 0}
                        </p>
                    </div>

                    <div className="rounded-xl bg-white p-5 shadow-md transition-shadow duration-300 hover:shadow-xl">
                        <h2 className="text-sm font-medium text-gray-400 uppercase">
                            Pending Approval
                        </h2>
                        <p className="mt-2 text-2xl font-bold text-gray-900">
                            {props.stats?.pendingApprovals ?? 0}
                        </p>
                    </div>
                </div>

                {/* Welcome Message / Tips */}
                <div className="mt-8 rounded-lg border-l-4 border-blue-400 bg-blue-50 p-5">
                    <p className="text-blue-700">
                        Tips: Gunakan menu navigasi untuk mengelola booking
                        kendaraan, melihat laporan, dan memeriksa log aktivitas.
                    </p>
                </div>
            </div>
        </AppLayout>
    );
}
