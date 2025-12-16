<?php

namespace App\Services;

use App\Repositories\DriverRepository;

class DriverService
{
    protected $driverRepo;

    public function __construct(DriverRepository $driverRepo)
    {
        $this->driverRepo = $driverRepo;
    }

    /**
     * Ambil semua driver
     */
public function getAllDrivers($perPage = 10)
{
    return $this->driverRepo->all($perPage);
}

    /**
     * Ambil driver aktif
     */
    public function getActiveDrivers()
    {
        return $this->driverRepo->active();
    }

    /**
     * Simpan driver baru
     */
    public function storeDriver(array $data)
    {
        return $this->driverRepo->create($data);
    }

    /**
     * Update driver
     */
    public function updateDriver($id, array $data)
    {
        return $this->driverRepo->update($id, $data);
    }

    /**
     * Hapus driver
     */
    public function deleteDriver($id)
    {
        return $this->driverRepo->delete($id);
    }
}
