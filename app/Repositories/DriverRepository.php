<?php

namespace App\Repositories;

use App\Models\Driver;

class DriverRepository
{
    protected $model;

    public function __construct(Driver $driver)
    {
        $this->model = $driver;
    }

    /**
     * Ambil semua driver
     */
 public function all($perPage = 10)
{
    return $this->model
        ->with(['region', 'office'])
    
        ->paginate($perPage); // <--- harus paginate, bukan get()
}

    /**
     * Ambil driver berdasarkan ID
     */
    public function find($id)
    {
        return $this->model->with(['region', 'office'])->find($id);
    }

    /**
     * Ambil driver aktif saja
     */
    public function active()
    {
        return $this->model->with(['region', 'office'])->where('status', 'active')->get();
    }

    /**
     * Simpan driver baru
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update driver
     */
    public function update($id, array $data)
    {
        $driver = $this->model->find($id);
        if (!$driver) return null;

        $driver->update($data);
        return $driver;
    }

    /**
     * Hapus driver
     */
    public function delete($id)
    {
        $driver = $this->model->find($id);
        if (!$driver) return false;

        return $driver->delete();
    }
}
