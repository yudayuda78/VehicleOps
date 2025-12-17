import AppLayout from '@/layouts/AppLayout';
import { usePage } from '@inertiajs/react';

export default function LogsIndex() {
    const { logs } = usePage().props;

    return (
        <AppLayout>
            <div className="p-6">
                <h1 className="mb-4 text-xl font-bold">Semua Booking Logs</h1>
                <div className="overflow-x-auto">
                    <table className="min-w-full rounded-lg border bg-white">
                        <thead className="bg-gray-100">
                            <tr>
                                <th className="border px-4 py-2">ID</th>
                                <th className="border px-4 py-2">Booking ID</th>
                                <th className="border px-4 py-2">Vehicle</th>
                                <th className="border px-4 py-2">User</th>
                                <th className="border px-4 py-2">Action</th>
                                <th className="border px-4 py-2">Note</th>
                                <th className="border px-4 py-2">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            {logs.map((log) => (
                                <tr key={log.id}>
                                    <td className="border px-4 py-2">
                                        {log.id}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.booking_id}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.vehicle}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.user}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.action}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.note}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {log.created_at}
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
