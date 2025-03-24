<?php

namespace App\Repositories\Eloquent;

use App\Models\Doctor;
use App\Repositories\Interfaces\DoctorRepositoryInterface;

class DashboardRepository implements DoctorRepositoryInterface
{
    public function getAll()
    {
        return Doctor::all();
    }

    public function getById($id)
    {
        return Doctor::findOrFail($id);
    }

    public function create(array $data)
    {
        return Doctor::create($data);
    }

    public function update($id, array $data)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($data);
        return $doctor;
    }

    public function delete($id)
    {
        return Doctor::destroy($id);
    }

}
