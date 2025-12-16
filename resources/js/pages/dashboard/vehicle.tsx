import AppLayout from '@/layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import {
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LinearScale,
    Title,
    Tooltip,
} from 'chart.js';
import { Bar } from 'react-chartjs-2';

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
);

type PageProps = {
    fuelUsage: { vehicle: { name: string }; total_usage: number }[];
    vehiclesService: {
        id: number;
        name: string;
        next_service_date: string;
        service_interval_km: number;
        status: string;
    }[];
    usageHistory: {
        id: number;
        vehicle: { name: string };
        driver: { name: string };
        date: string;
        status: string;
    }[];
};

export default function Dashboard() {
    const { fuelUsage, vehiclesService, usageHistory } =
        usePage<PageProps>().props;

    // Data chart BBM
    const chartData = {
        labels: fuelUsage.map((d) => d.vehicle.name),
        datasets: [
            {
                label: 'Jumlah Pemakaian',
                data: fuelUsage.map((d) => d.total_usage),
                backgroundColor: 'rgba(34,197,94,0.7)',
            },
        ],
    };

    return (
        <AppLayout>
            <h1 className="mb-6 text-2xl font-bold">Dashboard Kendaraan</h1>

            {/* Grafik Pemakaian / BBM */}
            <div className="mb-6 rounded-lg bg-white p-6 shadow">
                <h2 className="mb-4 text-lg font-semibold">
                    Pemakaian Kendaraan / Konsumsi BBM
                </h2>
                <Bar data={chartData} options={{ responsive: true }} />
            </div>

            {/* Jadwal Service */}
            <div className="mb-6 rounded-lg bg-white p-6 text-black shadow">
                <h2 className="mb-4 text-lg font-semibold">
                    Jadwal Service Kendaraan
                </h2>
                <table className="w-full border-collapse text-sm">
                    <thead className="bg-gray-50 text-gray-600">
                        <tr>
                            <th className="px-4 py-2 text-left">Kendaraan</th>
                            <th className="px-4 py-2 text-left">
                                Tanggal Service Berikutnya
                            </th>
                            <th className="px-4 py-2 text-left">
                                Interval (KM)
                            </th>
                            <th className="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {vehiclesService.map((v) => (
                            <tr
                                key={v.id}
                                className="border-t hover:bg-gray-50"
                            >
                                <td className="px-4 py-2">{v.name}</td>
                                <td className="px-4 py-2">
                                    {v.next_service_date}
                                </td>
                                <td className="px-4 py-2">
                                    {v.service_interval_km} km
                                </td>
                                <td className="px-4 py-2">{v.status}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            {/* Riwayat Pemakaian */}
            <div className="rounded-lg bg-white p-6 text-black shadow">
                <h2 className="mb-4 text-lg font-semibold">
                    Riwayat Pemakaian Kendaraan
                </h2>
                <table className="w-full border-collapse text-sm">
                    <thead className="bg-gray-50 text-gray-600">
                        <tr>
                            <th className="px-4 py-2 text-left">Tanggal</th>
                            <th className="px-4 py-2 text-left">Kendaraan</th>
                            <th className="px-4 py-2 text-left">Driver</th>
                            <th className="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {usageHistory.map((b) => (
                            <tr
                                key={b.id}
                                className="border-t hover:bg-gray-50"
                            >
                                <td className="px-4 py-2">{b.date}</td>
                                <td className="px-4 py-2">{b.vehicle.name}</td>
                                <td className="px-4 py-2">{b.driver.name}</td>
                                <td className="px-4 py-2">{b.status}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </AppLayout>
    );
}
