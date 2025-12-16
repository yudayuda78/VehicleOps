import AppLayout from '@/layouts/AppLayout';
import { Link, router, usePage } from '@inertiajs/react';

type Driver = {
    id: number;
    name: string;
    region: { id: number; name: string };
    office: { id: number; name: string } | null;
    status: 'active' | 'inactive';
};

type DriversProps = {
    drivers: {
        data: Driver[];
        links: { url: string | null; label: string; active: boolean }[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
};

export default function DriverIndex() {
    const { drivers } = usePage<DriversProps>().props;

    const handlePageChange = (url: string | null) => {
        if (!url) return;
        router.get(url, {}, { preserveState: true });
    };

    return (
        <AppLayout>
            <div className="flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-800">Drivers</h1>
                <Link
                    href="#"
                    className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
                >
                    + Add Driver
                </Link>
            </div>

            <div className="mt-6 overflow-hidden rounded-xl bg-white shadow">
                <table className="w-full border-collapse text-sm">
                    <thead className="bg-gray-50 text-gray-600">
                        <tr>
                            <th className="px-4 py-3 text-left">Name</th>
                            <th className="px-4 py-3 text-left">Region</th>
                            <th className="px-4 py-3 text-center">Office</th>
                            <th className="px-4 py-3 text-center">Status</th>
                            <th className="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {drivers.data.length === 0 && (
                            <tr>
                                <td
                                    colSpan={5}
                                    className="px-4 py-3 text-center text-gray-500"
                                >
                                    Tidak ada driver
                                </td>
                            </tr>
                        )}
                        {drivers.data.map((driver) => (
                            <tr
                                key={driver.id}
                                className="border-t text-black hover:bg-gray-50"
                            >
                                <td className="px-4 py-3">{driver.name}</td>
                                <td className="px-4 py-3">
                                    {driver.region?.name || '-'}
                                </td>
                                <td className="px-4 py-3 text-center">
                                    {driver.office?.name || '-'}
                                </td>
                                <td className="px-4 py-3 text-center">
                                    <StatusBadge status={driver.status} />
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

                {/* Pagination */}
                <div className="mt-4 flex justify-center space-x-2">
                    {drivers.links.map((link, index) => (
                        <button
                            key={index}
                            disabled={!link.url}
                            onClick={() => handlePageChange(link.url)}
                            className={`rounded border px-3 py-1 ${
                                link.active
                                    ? 'border-blue-600 bg-blue-600 text-white'
                                    : 'border-gray-300 bg-white text-gray-700'
                            }`}
                        >
                            <span
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        </button>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}

function StatusBadge({ status }: { status: string }) {
    const map: Record<string, string> = {
        active: 'bg-green-100 text-green-700',
        inactive: 'bg-red-100 text-red-700',
    };
    return (
        <span
            className={`rounded-full px-3 py-1 text-xs font-semibold ${map[status]}`}
        >
            {status.toUpperCase()}
        </span>
    );
}
