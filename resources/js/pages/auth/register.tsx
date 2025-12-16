import { Head, useForm } from '@inertiajs/react';

export default function Register({ regions }: { regions: any[] }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: 'admin',
        region_id: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/register');
    };

    return (
        <>
            <Head title="Register" />

            <form
                onSubmit={submit}
                className="mx-auto mt-20 max-w-md space-y-4"
            >
                <h1 className="text-2xl font-bold">Register</h1>

                <input
                    placeholder="Name"
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                    className="w-full border p-2"
                />

                <input
                    placeholder="Email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    className="w-full border p-2"
                />

                <input
                    type="password"
                    placeholder="Password"
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                    className="w-full border p-2"
                />

                <input
                    type="password"
                    placeholder="Confirm Password"
                    value={data.password_confirmation}
                    onChange={(e) =>
                        setData('password_confirmation', e.target.value)
                    }
                    className="w-full border p-2"
                />

                <select
                    value={data.role}
                    onChange={(e) => setData('role', e.target.value)}
                    className="w-full border p-2"
                >
                    <option value="admin">Admin</option>
                    <option value="approver">Approver</option>
                    <option value="superadmin">Super Admin</option>
                </select>

                {data.role !== 'superadmin' && (
                    <select
                        value={data.region_id}
                        onChange={(e) => setData('region_id', e.target.value)}
                        className="w-full border p-2"
                    >
                        <option value="">Pilih Region</option>
                        {regions.map((region) => (
                            <option key={region.id} value={region.id}>
                                {region.name}
                            </option>
                        ))}
                    </select>
                )}

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full bg-green-600 p-2 text-white"
                >
                    Register
                </button>
            </form>
        </>
    );
}
