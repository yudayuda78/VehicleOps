import AppLayout from '@/layouts/AppLayout';
import { usePage } from '@inertiajs/react';

export default function Dashboard() {
    const { props } = usePage<any>();
    const user = props.auth?.user;

    return (
        <AppLayout>
            <h1 className="text-2xl font-bold text-gray-800">
                Selamat datang{user ? `, ${user.name}` : ''}
            </h1>

            <p className="mt-2 text-gray-500">
                Role:{' '}
                <span className="font-medium text-gray-700">
                    {user?.role ?? '-'}
                </span>
            </p>
        </AppLayout>
    );
}
