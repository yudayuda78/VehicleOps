import { Head, useForm } from '@inertiajs/react';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/login');
    };

    return (
        <>
            <Head title="Login" />

            <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-600 to-blue-400 px-4">
                <div className="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
                    <h1 className="mb-2 text-center text-3xl font-bold text-blue-600">
                        VehicleOps
                    </h1>
                    <p className="mb-8 text-center text-sm text-gray-500">
                        Login ke sistem manajemen kendaraan
                    </p>

                    <form onSubmit={submit} className="space-y-5">
                        {/* Email */}
                        <div>
                            <label className="mb-1 block text-sm font-medium text-gray-700">
                                Email
                            </label>
                            <input
                                type="email"
                                placeholder="email@company.com"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                                className={`w-full rounded-lg border px-4 py-2 text-sm text-black focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none ${
                                    errors.email
                                        ? 'border-red-500'
                                        : 'border-gray-300'
                                }`}
                            />
                            {errors.email && (
                                <p className="mt-1 text-xs text-red-500">
                                    {errors.email}
                                </p>
                            )}
                        </div>

                        {/* Password */}
                        <div>
                            <label className="mb-1 block text-sm font-medium text-gray-700">
                                Password
                            </label>
                            <input
                                type="password"
                                placeholder="••••••••"
                                value={data.password}
                                onChange={(e) =>
                                    setData('password', e.target.value)
                                }
                                className={`w-full rounded-lg border px-4 py-2 text-sm text-black focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none ${
                                    errors.password
                                        ? 'border-red-500'
                                        : 'border-gray-300'
                                }`}
                            />
                            {errors.password && (
                                <p className="mt-1 text-xs text-red-500">
                                    {errors.password}
                                </p>
                            )}
                        </div>

                        {/* Button */}
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full rounded-lg bg-blue-600 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:opacity-60"
                        >
                            {processing ? 'Logging in...' : 'Login'}
                        </button>
                    </form>

                    {/* Footer */}
                    <p className="mt-6 text-center text-xs text-gray-400">
                        © {new Date().getFullYear()} VehicleOps
                    </p>
                </div>
            </div>
        </>
    );
}
