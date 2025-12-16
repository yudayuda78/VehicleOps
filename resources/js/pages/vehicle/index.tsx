import AppLayout from '@/layouts/AppLayout';
import { Head, Link } from '@inertiajs/react';

type Vehicle = {
    id: number;
    name: string;
    type: string;
    status: string;
};

interface Props {
    vehicles: Vehicle[];
}

export default function VehicleIndex({ vehicles }: Props) {
    return (
        <>
            <AppLayout>
                <Head title="Vehicle" />

                <div className="p-6">
                    <h1 className="mb-4 text-2xl font-bold text-black">
                        Daftar Kendaraan
                    </h1>

                    <table className="w-full border">
                        <thead>
                            <tr className="bg-gray-100 text-black">
                                <th className="border p-2">Nama</th>
                                <th className="border p-2">Jenis</th>
                                <th className="border p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {vehicles.map((vehicle) => (
                                <tr key={vehicle.id}>
                                    <td className="border p-2">
                                        {vehicle.name}
                                    </td>
                                    <td className="border p-2">
                                        {vehicle.type}
                                    </td>
                                    <td className="border p-2">
                                        {vehicle.status}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>

                    <Link
                        href="/"
                        className="mt-4 inline-block text-blue-600 underline"
                    >
                        Kembali ke Dashboard
                    </Link>
                </div>
            </AppLayout>
        </>
    );
}
