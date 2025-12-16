import AppLayout from '@/layouts/AppLayout';
import { Link, router, usePage } from '@inertiajs/react';
import { FormEvent, useState } from 'react';

type Vehicle = { id: number; name: string };
type Driver = { id: number; name: string };
type User = { id: number; name: string };

export default function VehicleBookingCreate() {
    const { vehicles, drivers, approverLevel1, approverLevel2, auth } =
        usePage<{
            vehicles: Vehicle[];
            drivers: Driver[];
            approverLevel1: User[];
            approverLevel2: User[];
            auth: { user: User };
        }>().props;

    const [vehicleId, setVehicleId] = useState('');
    const [driverId, setDriverId] = useState('');
    const [approver1, setApprover1] = useState('');
    const [approver2, setApprover2] = useState('');
    const [date, setDate] = useState('');
    const [errors, setErrors] = useState<{ [key: string]: string[] }>({});

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        console.log('Tanggal dikirim:', date);
        setErrors({});

        router.post(
            '/booking',
            {
                vehicle_id: vehicleId,
                driver_id: driverId,
                approver_level_1_id: approver1,
                approver_level_2_id: approver2,
                date,
                user_id: auth.user.id,
                created_by: auth.user.id,
            },
            {
                onError: (err) => setErrors(err),
            },
        );
    };

    return (
        <AppLayout>
            <div className="mb-4 flex items-center justify-between">
                <h1 className="text-2xl font-bold text-gray-800">
                    Tambah Booking Kendaraan
                </h1>
                <Link
                    href="/booking"
                    className="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-black hover:bg-gray-300"
                >
                    Kembali
                </Link>
            </div>

            <form
                onSubmit={handleSubmit}
                className="space-y-4 rounded-xl bg-white p-6 shadow"
            >
                {/* Kendaraan */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Kendaraan
                    </label>
                    <select
                        className="mt-1 w-full rounded border-gray-300 text-black"
                        value={vehicleId}
                        onChange={(e) => setVehicleId(e.target.value)}
                    >
                        <option value="">-- Pilih Kendaraan --</option>
                        {vehicles.map((v) => (
                            <option key={v.id} value={v.id}>
                                {v.name}
                            </option>
                        ))}
                    </select>
                    {errors.vehicle_id && (
                        <p className="text-sm text-red-500">
                            {errors.vehicle_id[0]}
                        </p>
                    )}
                </div>

                {/* Driver */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Driver
                    </label>
                    <select
                        className="mt-1 w-full rounded border-gray-300 text-black"
                        value={driverId}
                        onChange={(e) => setDriverId(e.target.value)}
                    >
                        <option value="">-- Pilih Driver --</option>
                        {drivers.map((d) => (
                            <option key={d.id} value={d.id}>
                                {d.name}
                            </option>
                        ))}
                    </select>
                    {errors.driver_id && (
                        <p className="text-sm text-red-500">
                            {errors.driver_id[0]}
                        </p>
                    )}
                </div>

                {/* Tanggal */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Tanggal Pemakaian
                    </label>
                    <input
                        type="date"
                        className="mt-1 w-full rounded border-gray-300 text-black"
                        value={date}
                        onChange={(e) => setDate(e.target.value)}
                    />
                    {errors.date && (
                        <p className="text-sm text-red-500">{errors.date[0]}</p>
                    )}
                </div>

                {/* Approver Level 1 */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Approver Level 1
                    </label>
                    <select
                        className="mt-1 w-full rounded border-gray-300 text-black"
                        value={approver1}
                        onChange={(e) => setApprover1(e.target.value)}
                    >
                        <option value="">-- Pilih Approver Level 1 --</option>
                        {approverLevel1.map((a) => (
                            <option key={a.id} value={a.id}>
                                {a.name}
                            </option>
                        ))}
                    </select>
                    {errors.approver_level_1_id && (
                        <p className="text-sm text-red-500">
                            {errors.approver_level_1_id[0]}
                        </p>
                    )}
                </div>

                {/* Approver Level 2 */}
                <div>
                    <label className="block text-sm font-medium text-gray-700">
                        Approver Level 2
                    </label>
                    <select
                        className="mt-1 w-full rounded border-gray-300 text-black"
                        value={approver2}
                        onChange={(e) => setApprover2(e.target.value)}
                    >
                        <option value="">-- Pilih Approver Level 2 --</option>
                        {approverLevel2.map((a) => (
                            <option key={a.id} value={a.id}>
                                {a.name}
                            </option>
                        ))}
                    </select>
                    {errors.approver_level_2_id && (
                        <p className="text-sm text-red-500">
                            {errors.approver_level_2_id[0]}
                        </p>
                    )}
                </div>

                <button
                    type="submit"
                    className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Simpan Booking
                </button>
            </form>
        </AppLayout>
    );
}
