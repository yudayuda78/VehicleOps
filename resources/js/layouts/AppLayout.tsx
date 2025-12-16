import { BellIcon } from '@heroicons/react/24/outline'; // Icon notifikasi
import { Link, router, usePage } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

const menu = [
    { name: 'Dashboard', href: '/dashboard' },
    { name: 'Office', href: '/office' },
    { name: 'Vehicle', href: '/vehicle' },
    { name: 'Vehicle Booking', href: '/booking' },
    { name: 'Driver', href: '/driver' },
];

export default function AppLayout({ children }: PropsWithChildren) {
    const { url, props } = usePage<any>();
    const user = props.auth?.user;

    const notifications = props.notifications || []; // asumsi dari backend

    return (
        <div className="flex min-h-screen bg-gray-100">
            {/* Sidebar */}
            <aside className="w-64 bg-slate-900 text-white">
                <div className="border-b border-slate-700 p-4 text-xl font-bold">
                    VehicleOps
                </div>
                <nav className="space-y-1 p-2">
                    {menu.map((item) => (
                        <Link
                            key={item.href}
                            href={item.href}
                            className={`block rounded px-4 py-2 transition ${
                                url === item.href
                                    ? 'bg-slate-700 text-white'
                                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                            }`}
                        >
                            {item.name}
                        </Link>
                    ))}
                </nav>
            </aside>

            {/* Main */}
            <div className="flex flex-1 flex-col">
                {/* Navbar */}
                <header className="flex h-14 items-center justify-between border-b bg-white px-6">
                    <div className="text-sm text-gray-500">Dashboard</div>

                    <div className="flex items-center gap-4">
                        {/* Notifikasi */}
                        <div className="relative">
                            <BellIcon className="h-6 w-6 text-gray-600" />
                            {notifications.length > 0 && (
                                <span className="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                                    {notifications.length}
                                </span>
                            )}
                        </div>

                        {user && (
                            <>
                                <div className="text-right">
                                    <div className="text-sm font-medium text-gray-800">
                                        {user.name}
                                    </div>
                                    <div className="text-xs text-gray-500">
                                        {user.role}
                                    </div>
                                </div>

                                <button
                                    onClick={() => router.post('/logout')}
                                    className="rounded-md bg-red-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-600"
                                >
                                    Logout
                                </button>
                            </>
                        )}
                    </div>
                </header>

                {/* Content */}
                <main className="flex-1 p-6">{children}</main>
            </div>
        </div>
    );
}
