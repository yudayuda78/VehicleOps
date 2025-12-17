# VehicleOps
# Vehicle Booking System

Aplikasi web untuk pemesanan dan monitoring kendaraan perusahaan, termasuk konsumsi BBM, jadwal service, dan riwayat pemakaian kendaraan. Dibangun menggunakan **Laravel 11 + Inertia.js + React + Tailwind CSS**.

---

## 1. Informasi Login

| Username               | Password   | Role            | Office Type       |
| --------------------- | --------- | --------------- | ---------------- |
| admin@vehicle.com      | password  | Admin           | Head Office      |
| approver1@vehicle.com  | password  | Approver Level 1| Branch Office    |
| approver2@vehicle.com  | password  | Approver Level 2| Head Office      |

> **Catatan:** Ganti password default setelah login pertama untuk keamanan.

---

## 2. Spesifikasi Sistem

- **PHP Version:** 8.2
- **Laravel Version:** 11.x
- **Database:** MySQL 8.0 / PostgreSQL 15
- **Frontend:** React + Inertia.js
- **UI Framework:** Tailwind CSS
- **Excel Export:** Laravel Excel (`maatwebsite/excel`)

---

## 3. Instalasi

1. Clone repository:
   ```bash
   git clone https://github.com/username/vehicle-booking.git
   cd vehicle-booking
2. Install dependencies backend (Laravel):
   ```bash
   composer install
3. Install dependencies frontend (React + Vite):
    ```bash
    npm install
    npm run dev
4. Copy file environment:
   ```bash
   cp .env.example .env
5. Generate application key:
   ```bash
   php artisan key:generate
6. Jalankan migrasi dan seed data awal:
   ```bash
   php artisan migrate --seed

## 4. Run Aplikasi

1. Jalankan backend:
   ```bash
   php artisan serve
2. Jalankan frontend:
   ```bash
   npm run dev


## 4. Panduan Penggunaan

1. Admin
    Login sebagai admin.
    Membuat pemesanan kendaraan:
        Pilih kendaraan dan driver.
        Pilih approver level 1 & 2.
        Tentukan tanggal pemakaian.
    Melihat semua pemesanan kendaraan.
    Mengekspor data pemesanan ke Excel melalui halaman laporan.
    Log setiap aksi otomatis tersimpan.

2. Approver
    Login sebagai approver (Level 1 atau Level 2).
    Melihat pemesanan yang menunggu persetujuan:
        Branch Office → status draft
        Head Office → status pending
    Approve atau reject pemesanan.
    Catatan persetujuan disimpan otomatis di log.

Laporan
    Halaman laporan menampilkan semua pemesanan kendaraan.
    Filter laporan berdasarkan tanggal mulai dan akhir.
    Export laporan ke file Excel (.xlsx).
